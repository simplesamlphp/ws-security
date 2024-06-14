<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement;
use SimpleSAML\WSSecurity\XML\wsx\MetadataReference;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsx:MetadataReference.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(MetadataReference::class)]
#[CoversClass(AbstractWsxElement::class)]
final class MetadataReferenceTest extends TestCase
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
        self::$testedClass = MetadataReference::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/MetadataExchange.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_MetadataReference.xml',
        );

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an MetadataReference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', 'value1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');

        $chunk = new Chunk(self::$customContent);

        $endpointReference = new EndpointReference(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [],
            [],
            [$chunk],
            [$attr1],
        );

        $metadataReference = new MetadataReference([$endpointReference]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($metadataReference),
        );
    }
}
