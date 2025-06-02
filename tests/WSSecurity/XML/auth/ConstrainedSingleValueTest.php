<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\XML\auth\{
    AbstractAuthElement,
    AbstractConstrainedSingleValueType,
    StructuredValue,
    Value,
    ValueGreaterThan,
    ValueGreaterThanOrEqual,
    ValueLessThan,
    ValueLessThanOrEqual,
    ValueLowerBound,
    ValueUpperBound,
};
use SimpleSAML\XML\{Attribute as XMLAttribute, Chunk, DOMDocumentFactory};
use SimpleSAML\XML\Type\StringValue;

/**
 * Tests for auth:ConstrainedSingleValueType.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ValueGreaterThan::class)]
#[CoversClass(ValueGreaterThanOrEqual::class)]
#[CoversClass(ValueLessThan::class)]
#[CoversClass(ValueLessThanOrEqual::class)]
#[CoversClass(ValueLowerBound::class)]
#[CoversClass(ValueUpperBound::class)]
#[CoversClass(AbstractConstrainedSingleValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ConstrainedSingleValueTest extends TestCase
{
    /**
     * Test creating an object from scratch.
     *
     * @param class-string $class
     */
    #[DataProvider('classProvider')]
    public function testMarshallingEmpty(string $class): void
    {
        $x = new $class(null, null);
        $this->assertTrue($x->isEmptyElement());
    }


    /**
     * Test creating an object from scratch with both Value and StructuredValue.
     *
     * @param class-string $class
     */
    #[DataProvider('classProvider')]
    public function testMarshallingIllegalCombination(string $class): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $value = new Value(StringValue::fromString('MyValue'));

        $this->expectException(AssertionFailedException::class);
        new $class($value, $structuredValue);
    }


    /**
     */
    public static function classProvider(): array
    {
        return [
            'auth:ValueUpperBound' => [ValueUpperBound::class],
            'auth:ValueLowerBound' => [ValueLowerBound::class],
            'auth:ValueLessThan' => [ValueLessThan::class],
            'auth:ValueLessThanOrEqual' => [ValueLessThanOrEqual::class],
            'auth:ValueGreaterThan' => [ValueGreaterThan::class],
            'auth:ValueGreaterThanOrEqual' => [ValueGreaterThanOrEqual::class],
        ];
    }
}
