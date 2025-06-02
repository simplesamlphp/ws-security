<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\{
    AbstractAuthElement,
    AbstractConstrainedManyValueType,
    StructuredValue,
    ValueOneOf,
};
use SimpleSAML\XML\{Attribute as XMLAttribute, Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:Value.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ValueOneOf::class)]
#[CoversClass(AbstractConstrainedManyValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueOneOfWithStructuredValuesTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueOneOf::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueOneOfWithStructuredValues.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueOneOf object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $child1 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $child2 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeOtherChunk</ssp:Chunk>',
        );

        $structuredValue1 = new StructuredValue(
            [new Chunk($child1->documentElement)],
            [$attr1],
        );

        $structuredValue2 = new StructuredValue(
            [new Chunk($child2->documentElement)],
            [$attr2],
        );

        $valueOneOf = new ValueOneOf([], [$structuredValue1, $structuredValue2]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueOneOf),
        );
    }
}
