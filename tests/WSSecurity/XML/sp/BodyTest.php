<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\Body;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\BodyTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\Body
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractEmptyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class BodyTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Body::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_Body.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating a Body from scratch works.
     */
    public function testMarshalling(): void
    {
        $body = new Body();

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body),
        );
    }


    // test unmarshalling


    /**
     * Test that creating a Body from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $body = Body::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body),
        );
    }
}
