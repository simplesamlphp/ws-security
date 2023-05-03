<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\Metadata;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsa\MetadataTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\Metadata
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 *
 * @package tvdijen/ws-security
 */
final class MetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $MetadataContent */
    private DOMElement $metadataContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Metadata::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_Metadata.xml'
        );

        $this->metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:attr1');
        $domAttr->value = 'value1';

        $metadata = new Metadata([new Chunk($this->metadataContent)], [$domAttr]);
        $this->assertFalse($metadata->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($metadata)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $metadata = new Metadata([], []);
        $this->assertEquals(
            '<wsa:Metadata xmlns:wsa="http://www.w3.org/2005/08/addressing"/>',
            strval($metadata)
        );
        $this->assertTrue($metadata->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $metadata = Metadata::fromXML($this->xmlRepresentation->documentElement);

        $elements = $metadata->getElements();
        $this->assertFalse($metadata->isEmptyElement());
        $this->assertCount(1, $elements);

        $attributes = $metadata->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = end($attributes);
        $this->assertEquals('ssp:attr1', $attribute['qualifiedName']);
        $this->assertEquals('value1', $attribute['value']);
    }
}
