<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\ConstrainedValue;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\auth\ValueGreaterThan;
use SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual;
use SimpleSAML\WSSecurity\XML\auth\ValueLessThan;
use SimpleSAML\WSSecurity\XML\auth\ValueLessThanOrEqual;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for auth:ConstrainedValue.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\ConstrainedValue
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package tvdijen/ws-security
 */
final class ConstrainedValueTest extends TestCase
{
    private static string $resourcePath;

    private static StructuredValue $structuredValue;

    private static Value $value;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$resourcePath = dirname(__FILE__, 4) . '/resources/xml/';

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        self::$structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        self::$value = new Value('MyValue');
    }


    // test marshalling


    /**
     * Test creating a ConstrainedValue object from scratch.
     *
     * @dataProvider classProvider
     *
     * @param class-string $class
     * @param string $xmlRepresentation
     */
    public function testMarshalling(string $class, string $xmlRepresentation): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromFile(
            self::$resourcePath . $xmlRepresentation,
        );

        /**
         * @var (
         *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThan|
         *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThanOrEqual|
         *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThan|
         *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual|
         *   \SimpleSAML\WSSecurity\XML\auth\ValueInRangen|
         *   \SimpleSAML\WSSecurity\XML\auth\ValueOneOf
         * ) $item
         */
        $item = new $class(self::$value, null);
        $constrainedValue = new ConstrainedValue($item, [], true);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($constrainedValue),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ConstrainedValue from XML.
     *
     * @dataProvider classProvider
     *
     * @param class-string $class
     * @param string $xmlRepresentation
     */
    public function testUnmarshalling(string $class, string $xmlRepresentation): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromFile(
            self::$resourcePath . $xmlRepresentation,
        );

        $constrainedValue = ConstrainedValue::fromXML($xmlRepresentation->documentElement);
        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($constrainedValue),
        );
    }


    /**
     */
    public static function classProvider(): array
    {
        return [
            /** TODO
            'auth:ValueInRangen' => [
                ValueInRangen::class,
                'auth_ConstrainedValueWithValueInRangen.xml',
            ],
            'auth:ValueOneOf' => [
                ValueOneOf::class,
                'auth_ConstrainedValueWithValueOneOf.xml',
            ],
            */
            'auth:ValueLessThan' => [
                ValueLessThan::class,
                'auth_ConstrainedValueWithValueLessThan.xml',
            ],
            'auth:ValueLessThanOrEqual' => [
                ValueLessThanOrEqual::class,
                'auth_ConstrainedValueWithValueLessThanOrEqual.xml',
            ],
            'auth:ValueGreaterThan' => [
                ValueGreaterThan::class,
                'auth_ConstrainedValueWithValueGreaterThan.xml',
            ],
            'auth:ValueGreaterThanOrEqual' => [
                ValueGreaterThanOrEqual::class,
                'auth_ConstrainedValueWithValueGreaterThanOrEqual.xml',
            ],
        ];
    }
}
