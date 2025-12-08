<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\XPath;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for XPath.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(XPath::class)]
#[CoversClass(AbstractSpElement::class)]
final class XPathTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = XPath::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/XPath.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a XPath object from scratch.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath(StringValue::fromString('/bookstore/book[price>35.00]/title'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($xpath),
        );
    }
}
