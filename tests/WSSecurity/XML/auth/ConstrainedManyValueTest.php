<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\auth\ValueOneOf;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

/**
 * Tests for auth:ConstrainedManyValueType.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedManyValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package simplesamlphp/ws-security
 */
final class ConstrainedManyValueTest extends TestCase
{
    /**
     * Test creating an object from scratch.
     *
     * @param class-string $class
     *
     * @dataProvider classProvider
     */
    public function testMarshallingEmpty(string $class): void
    {
        $x = new $class([], []);
        $this->assertTrue($x->isEmptyElement());
    }


    /**
     * Test creating an object from scratch with both Value and StructuredValue.
     *
     * @param class-string $class
     *
     * @dataProvider classProvider
     */
    public function testMarshallingIllegalCombination(string $class): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $value = new Value('MyValue');

        $this->expectException(AssertionFailedException::class);
        new $class([$value], [$structuredValue]);
    }


    /**
     */
    public static function classProvider(): array
    {
        return [
            'auth:ValueOneOf' => [ValueOneOf::class],
        ];
    }
}
