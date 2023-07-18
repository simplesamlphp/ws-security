<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\auth\ValueInRangen;
use SimpleSAML\WSSecurity\XML\auth\ValueLowerBound;
use SimpleSAML\WSSecurity\XML\auth\ValueUpperBound;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueInRangen.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\ValueInRangen
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractValueInRangeType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package tvdijen/ws-security
 */
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
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $valueUpperBound = new ValueUpperBound(null, $structuredValue);
        $valueLowerBound = new ValueLowerBound(new Value('MyValue'), null);
        $valueInRangen = new ValueInRangen($valueUpperBound, $valueLowerBound);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueInRangen),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ValueInRangen from XML.
     */
    public function testUnmarshalling(): void
    {
        $valueInRangen = ValueInRangen::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueInRangen),
        );
    }
}
