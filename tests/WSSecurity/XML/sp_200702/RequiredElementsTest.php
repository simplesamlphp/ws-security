<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath as XMLXPath;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSerElementsType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\RequiredElements;
use SimpleSAML\WSSecurity\XML\sp_200702\XPath;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\RequiredElementsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(RequiredElements::class)]
#[CoversClass(AbstractSerElementsType::class)]
#[CoversClass(AbstractSpElement::class)]
final class RequiredElementsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequiredElements::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/RequiredElements.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $xpath = new XPath(StringValue::fromString('/bookstore/book[price>35.00]/title'));
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $requiredElements = new RequiredElements(
            [$xpath],
            AnyURIValue::fromString('urn:x-simplesamlphp:version'),
            [$chunk],
            [$attr],
        );
        $requiredElementsElement = $requiredElements->toXML();

        // Test for an XPath
        $xpCache = XMLXPath::getXPath($requiredElementsElement);
        $requiredElementsElements = XMLXPath::xpQuery($requiredElementsElement, './sp:XPath', $xpCache);
        $this->assertCount(1, $requiredElementsElements);

        // Test ordering of RequiredElements contents
        /** @psalm-var \DOMElement[] $requiredElementsElements */
        $requiredElementsElements = XMLXPath::xpQuery(
            $requiredElementsElement,
            './sp:XPath/following-sibling::*',
            $xpCache,
        );

        $this->assertCount(1, $requiredElementsElements);
        $this->assertEquals('ssp:Chunk', $requiredElementsElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a RequiredElements from scratch works.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath(StringValue::fromString('/bookstore/book[price>35.00]/title'));
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $requiredElements = new RequiredElements(
            [$xpath],
            AnyURIValue::fromString('urn:x-simplesamlphp:version'),
            [$chunk],
            [$attr],
        );
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requiredElements),
        );
    }
}
