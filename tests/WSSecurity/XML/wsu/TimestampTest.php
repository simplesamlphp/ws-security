<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsu;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsu\AbstractTimestamp;
use SimpleSAML\WSSecurity\XML\wsu\AbstractWsuElement;
use SimpleSAML\WSSecurity\XML\wsu\Created;
use SimpleSAML\WSSecurity\XML\wsu\Expires;
use SimpleSAML\WSSecurity\XML\wsu\Timestamp;
use SimpleSAML\WSSecurity\XML\wsu\Type\DateTimeValue;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsu:Timestamp.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsu')]
#[CoversClass(Timestamp::class)]
#[CoversClass(AbstractTimestamp::class)]
#[CoversClass(AbstractWsuElement::class)]
final class TimestampTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Timestamp::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsu_Timestamp.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Created object from scratch.
     */
    public function testMarshalling(): void
    {
        $created = new Created(DateTimeValue::fromString('2001-09-13T08:42:00Z'));
        $expires = new Expires(DateTimeValue::fromString('2001-10-13T09:00:00Z'));
        $timestamp = new Timestamp($created, $expires, IDValue::fromString('abc123'), [], []);

        $this->assertFalse($timestamp->isEmptyElement());
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($timestamp),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $timestamp = new Timestamp();

        $this->assertTrue($timestamp->isEmptyElement());
    }
}
