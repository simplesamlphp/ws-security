<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath as XMLXPath;
use SimpleSAML\WSSecurity\XML\sp\EncryptedElements;
use SimpleSAML\WSSecurity\XML\sp\XPath;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\EncryptedElementsTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\EncryptedElements
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSerElementsType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class EncryptedElementsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = EncryptedElements::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_EncryptedElements.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $EncryptedElements = new EncryptedElements([$xpath], 'urn:x-simplesamlphp:version', [$chunk], [$attr]);
        $EncryptedElementsElement = $EncryptedElements->toXML();

        // Test for an XPath
        $xpCache = XMLXPath::getXPath($EncryptedElementsElement);
        $EncryptedElementsElements = XMLXPath::xpQuery($EncryptedElementsElement, './sp:XPath', $xpCache);
        $this->assertCount(1, $EncryptedElementsElements);

        // Test ordering of EncryptedElements contents
        /** @psalm-var \DOMElement[] $EncryptedElementsElements */
        $EncryptedElementsElements = XMLXPath::xpQuery(
            $EncryptedElementsElement,
            './sp:XPath/following-sibling::*',
            $xpCache,
        );

        $this->assertCount(1, $EncryptedElementsElements);
        $this->assertEquals('ssp:Chunk', $EncryptedElementsElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a EncryptedElements from scratch works.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $EncryptedElements = new EncryptedElements([$xpath], 'urn:x-simplesamlphp:version', [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($EncryptedElements),
        );
    }
}
