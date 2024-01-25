<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\RelativeTo;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:RelativeTo.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\RelativeTo
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractRelativeToType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class RelativeToTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = RelativeTo::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_RelativeTo.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RelativeTo object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $relativeTo = new RelativeTo(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($relativeTo),
        );
    }


    /**
     * Adding an empty RelativeTo element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $fedns = C::NS_FED;
        $relativeTo = new RelativeTo();
        $this->assertEquals(
            "<fed:RelativeTo xmlns:fed=\"$fedns\"/>",
            strval($relativeTo),
        );
        $this->assertTrue($relativeTo->isEmptyElement());
    }
}
