<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Metadata;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\ReferenceParameters;
use SimpleSAML\WSSecurity\XML\wst_200512\Issuer;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wst:Issuer.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Issuer::class)]
final class IssuerTest extends TestCase
{
    use SerializableElementTestTrait;


    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;

    /** @var \DOMElement $metadataContent */
    protected static DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Issuer::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/Issuer.xml',
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an Issuer object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', StringValue::fromString('value1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', StringValue::fromString('value2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', StringValue::fromString('value3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', StringValue::fromString('value4'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$attr4]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr3]);
        $chunk = new Chunk(self::$customContent);

        $issuer = new Issuer(
            new Address(
                AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'),
                [$attr2],
            ),
            $referenceParameters,
            $metadata,
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuer),
        );
    }
}
