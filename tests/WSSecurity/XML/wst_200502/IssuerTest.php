<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\XML\wsa_200408\Address;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceParameters;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\Issuer;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:Issuer.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Issuer::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWstElement::class)]
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
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/Issuer.xml',
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
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
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', 'value4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $chunk = new Chunk(self::$customContent);

        $issuer = new Issuer(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            null,
            $referenceParameters,
            null,
            null,
            [$chunk],
            [$attr4],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuer),
        );
    }
}
