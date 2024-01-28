<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\auth\ValueLowerBound;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueLowerBound.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\ValueLowerBound
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedSingleValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package simplesamlphp/ws-security
 */
final class ValueLowerBoundTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueLowerBound::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueLowerBound.xml'
        );
    }


    // test marshalling


    /**
     * Test creating a ValueLowerBound object from scratch.
     */
    public function testMarshalling(): void
    {
        $valueLowerBound = new ValueLowerBound(new Value('MyValue'));

        $this->assertFalse($valueLowerBound->isEmptyElement());
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueLowerBound),
        );
    }
}
