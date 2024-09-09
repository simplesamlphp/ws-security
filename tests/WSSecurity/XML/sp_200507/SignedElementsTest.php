<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath as XMLXPath;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSerElementsType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\SignedElements;
use SimpleSAML\WSSecurity\XML\sp_200507\XPath;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\SignedElementsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(SignedElements::class)]
#[CoversClass(AbstractSerElementsType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SignedElementsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.1.xsd';

        self::$testedClass = SignedElements::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/SignedElements.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $SignedElements = new SignedElements([$xpath], 'urn:x-simplesamlphp:version', [$chunk], [$attr]);
        $SignedElementsElement = $SignedElements->toXML();

        // Test for an XPath
        $xpCache = XMLXPath::getXPath($SignedElementsElement);
        $SignedElementsElements = XMLXPath::xpQuery($SignedElementsElement, './sp:XPath', $xpCache);
        $this->assertCount(1, $SignedElementsElements);

        // Test ordering of SignedElements contents
        /** @psalm-var \DOMElement[] $SignedElementsElements */
        $SignedElementsElements = XMLXPath::xpQuery(
            $SignedElementsElement,
            './sp:XPath/following-sibling::*',
            $xpCache,
        );

        $this->assertCount(1, $SignedElementsElements);
        $this->assertEquals('ssp:Chunk', $SignedElementsElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a SignedElements from scratch works.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $SignedElements = new SignedElements([$xpath], 'urn:x-simplesamlphp:version', [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($SignedElements),
        );
    }
}
