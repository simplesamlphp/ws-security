<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\WSSecurity\XML\wsa\RelatesTo;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\RelatesToTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\RelatesTo
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package tvdijen/ws-security
 */
final class RelatesToTest extends TestCase
{
    use SerializableElementTestTrait;

    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = RelatesTo::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wsa_RelatesTo.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $relatesTo = new RelatesTo('http://www.w3.org/2005/08/addressing/reply', [$domAttr]);
        $this->assertFalse($relatesTo->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($relatesTo)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $relatesTo = new RelatesTo(null, []);
        $this->assertEquals(
            '<wsa:RelatesTo xmlns:wsa="http://www.w3.org/2005/08/addressing"/>',
            strval($relatesTo)
        );
        $this->assertTrue($relatesTo->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $relatesTo = RelatesTo::fromXML($this->xmlRepresentation->documentElement);
        $this->assertFalse($relatesTo->isEmptyElement());
        $this->assertEquals('http://www.w3.org/2005/08/addressing/reply', $relatesTo->getRelationshipType());

        $attributes = $relatesTo->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = end($attributes);
        $this->assertEquals('test:attr1', $attribute['qualifiedName']);
        $this->assertEquals('urn:test:something', $attribute['namespaceURI']);
        $this->assertEquals('testval1', $attribute['value']);
    }
}
