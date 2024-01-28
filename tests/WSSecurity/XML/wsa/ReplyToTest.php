<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\Metadata;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\WSSecurity\XML\wsa\ReplyTo;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:ReplyTo.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\ReplyTo
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package simplesamlphp/ws-security
 */
final class ReplyToTest extends TestCase
{
    use SchemaValidationTestTrait;
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
        self::$testedClass = ReplyTo::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ReplyTo.xml'
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>'
        )->documentElement;

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>'
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an ReplyTo object from scratch.
     */
    public function testMarshalling(): void
    {
        $doc = DOMDocumentFactory::fromString('<root/>');

        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', 'value1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', 'value3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', 'value4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$attr4]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr3]);
        $chunk = new Chunk(self::$customContent);

        $replyTo = new ReplyTo(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [$referenceParameters],
            [$metadata],
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($replyTo)
        );
    }
}
