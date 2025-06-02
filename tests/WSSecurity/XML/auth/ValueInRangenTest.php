<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\{
    AbstractAuthElement,
    AbstractValueInRangeType,
    StructuredValue,
    Value,
    ValueInRangen,
    ValueLowerBound,
    ValueUpperBound,
};
use SimpleSAML\XML\{Attribute as XMLAttribute, Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueInRangen.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ValueInRangen::class)]
#[CoversClass(AbstractValueInRangeType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueInRangenTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueInRangen::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueInRangen.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueInRangen object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $valueUpperBound = new ValueUpperBound(null, $structuredValue);
        $valueLowerBound = new ValueLowerBound(
            new Value(StringValue::fromString('MyValue')),
            null,
        );
        $valueInRangen = new ValueInRangen($valueUpperBound, $valueLowerBound);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueInRangen),
        );
    }
}
