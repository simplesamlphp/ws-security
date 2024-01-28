<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\Reason;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\ReasonTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\Reason
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package simplesamlphp/ws-security
 */
final class ReasonTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Reason::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Reason.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Reason object from scratch.
     */
    public function testMarshalling(): void
    {
        $reason = new Reason('phpunit');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($reason),
        );
    }
}
