<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\auth\ValueOneOf;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:Value.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\ValueOneOf
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedManyValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package tvdijen/ws-security
 */
final class ValueOneOfWithValuesTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueOneOf::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueOneOfWithValues.xml'
        );
    }


    // test marshalling


    /**
     * Test creating a ValueOneOf object from scratch.
     */
    public function testMarshalling(): void
    {
        $value1 = new Value('MyValue');
        $value2 = new Value('MyOtherValue');
        $valueOneOf = new ValueOneOf([$value1, $value2]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueOneOf),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ValueOneOf from XML.
     */
    public function testUnmarshalling(): void
    {
        $valueOneOf = ValueOneOf::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueOneOf),
        );
    }
}
