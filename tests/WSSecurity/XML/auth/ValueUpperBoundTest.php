<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement;
use SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedSingleValueType;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\ValueUpperBound;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueUpperBound.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ValueUpperBound::class)]
#[CoversClass(AbstractConstrainedSingleValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueUpperBoundTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueUpperBound::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueUpperBound.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueUpperBound object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $valueUpperBound = new ValueUpperBound(null, $structuredValue);

        $this->assertFalse($valueUpperBound->isEmptyElement());
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueUpperBound),
        );
    }
}
