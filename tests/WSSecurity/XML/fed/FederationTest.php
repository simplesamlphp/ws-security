<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\Federation;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:Federation.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\Federation
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFederationType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
final class FederationTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Federation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_Federation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Federation object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $federation = new Federation(
            'urn:some:uri',
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federation),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $federation = new Federation();
        $this->assertTrue($federation->isEmptyElement());
    }
}
