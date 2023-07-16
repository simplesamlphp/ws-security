<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:Value.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\Value
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package tvdijen/ws-security
 */
final class ValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Value::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_Value.xml'
        );
    }


    // test marshalling


    /**
     * Test creating a Value object from scratch.
     */
    public function testMarshalling(): void
    {
        $value = new Value('MyValue');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($value),
        );
    }


    // test unmarshalling


    /**
     * Test creating a Value from XML.
     */
    public function testUnmarshalling(): void
    {
        $value = Value::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($value),
        );
    }
}
