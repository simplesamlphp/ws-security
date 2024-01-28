<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\XPath;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for XPath.
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\XPath
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package simplesamlphp/ws-security
 */
final class XPathTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = XPath::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_XPath.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a XPath object from scratch.
     */
    public function testMarshalling(): void
    {
        $xpath = new XPath('/bookstore/book[price>35.00]/title');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($xpath),
        );
    }
}
