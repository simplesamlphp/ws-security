<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath as XMLXPath;
use SimpleSAML\WSSecurity\XML\sp\ContentEncryptedElements;
use SimpleSAML\WSSecurity\XML\sp\XPath;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\ContentEncryptedElementsTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\ContentEncryptedElements
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSerElementsType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class ContentEncryptedElementsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = ContentEncryptedElements::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_ContentEncryptedElements.xml',
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

        $contentEncryptedElements = new ContentEncryptedElements(
            [$xpath],
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );
        $contentEncryptedElementsElement = $contentEncryptedElements->toXML();

        // Test for an XPath
        $xpCache = XMLXPath::getXPath($contentEncryptedElementsElement);
        $contentEncryptedElementsElements = XMLXPath::xpQuery(
            $contentEncryptedElementsElement,
            './sp:XPath',
            $xpCache,
        );
        $this->assertCount(1, $contentEncryptedElementsElements);

        // Test ordering of ContentEncryptedElements contents
        /** @psalm-var \DOMElement[] $contentEncryptedElementsElements */
        $contentEncryptedElementsElements = XMLXPath::xpQuery(
            $contentEncryptedElementsElement,
            './sp:XPath/following-sibling::*',
            $xpCache,
        );
        $this->assertCount(1, $contentEncryptedElementsElements);
        $this->assertEquals('ssp:Chunk', $contentEncryptedElementsElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a ContentEncryptedElements from scratch works.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $contentEncryptedElements = new ContentEncryptedElements(
            [$xpath],
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($contentEncryptedElements),
        );
    }
}
