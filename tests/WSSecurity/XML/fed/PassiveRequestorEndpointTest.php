<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\PassiveRequestorEndpoint;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsa\Metadata;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:PassiveRequestorEndpoint.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\PassiveRequestorEndpoint
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractEndpointType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class PassiveRequestorEndpointTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $endpointReference */
    protected static DOMElement $endpointReference;

    /** @var \DOMElement $referenceParameters */
    protected static DOMElement $referenceParameters;

    /** @var \DOMElement $metadataContent */
    protected static DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PassiveRequestorEndpoint::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_PassiveRequestorEndpoint.xml'
        );

        self::$referenceParameters = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>'
        )->documentElement;

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>'
        )->documentElement;

        self::$endpointReference = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_EndpointReference.xml',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an PassiveRequestorEndpoint object from scratch.
     */
    public function testMarshalling(): void
    {
        $doc = DOMDocumentFactory::fromString('<root/>');

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', 'value1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', 'value3');
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', 'value4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParameters)], [$attr4]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr3]);
        $chunk = new Chunk(self::$customContent);

        $endpointReference = new EndpointReference(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [$referenceParameters],
            [$metadata],
            [$chunk],
            [$attr1],
        );

        $passiveRequestorEndpoint = new PassiveRequestorEndpoint([$endpointReference]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($passiveRequestorEndpoint),
        );
    }
}
