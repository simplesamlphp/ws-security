<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\RelatesTo;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsa\RelatesToTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\RelatesTo
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 *
 * @package tvdijen/ws-security
 */
final class RelatesToTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RelatesTo::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_RelatesTo.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', 'testval1');

        $relatesTo = new RelatesTo('http://www.w3.org/2005/08/addressing/reply', [$domAttr]);
        $this->assertFalse($relatesTo->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
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
        $relatesTo = RelatesTo::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertFalse($relatesTo->isEmptyElement());
        $this->assertEquals('http://www.w3.org/2005/08/addressing/reply', $relatesTo->getRelationshipType());

        $attributes = $relatesTo->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = array_pop($attributes);
        $this->assertEquals(
            [
                'namespaceURI' => 'urn:test:something',
                'namespacePrefix' => 'test',
                'attrName' => 'attr1',
                'attrValue' => 'testval1',
            ],
            $attribute->toArray(),
        );
    }
}
