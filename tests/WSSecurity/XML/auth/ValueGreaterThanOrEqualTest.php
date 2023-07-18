<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueGreaterThanOrEqual.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractConstrainedSingleValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package tvdijen/ws-security
 */
final class ValueGreaterThanOrEqualTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueGreaterThanOrEqual::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ValueGreaterThanOrEqual.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueGreaterThanOrEqual object from scratch.
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

        $valueGreaterThanOrEqual = new ValueGreaterThanOrEqual(null, $structuredValue);

        $this->assertFalse($valueGreaterThanOrEqual->isEmptyElement());
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueGreaterThanOrEqual),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ValueGreaterThanOrEqual from XML.
     */
    public function testUnmarshalling(): void
    {
        $valueGreaterThanOrEqual = ValueGreaterThanOrEqual::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueGreaterThanOrEqual),
        );
    }
}
