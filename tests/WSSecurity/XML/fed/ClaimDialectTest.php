<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\ClaimDialect;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:ClaimDialect.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\ClaimDialect
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractClaimDialectType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class ClaimDialectTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimDialect::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ClaimDialect.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ClaimDialect object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $claimDialect = new ClaimDialect(
            'urn:some:uri',
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimDialect),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $this->expectException(AssertionFailedException::class);
        new ClaimDialect();
    }


    // test unmarshalling


    /**
     * Test creating a ClaimDialect from XML.
     */
    public function testUnmarshalling(): void
    {
        $claimDialect = ClaimDialect::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimDialect),
        );
    }
}
