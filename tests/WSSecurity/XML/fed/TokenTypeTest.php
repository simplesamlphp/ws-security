<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\TokenType;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:TokenType.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\TokenType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractTokenType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package simplesamlphp/ws-security
 */
final class TokenTypeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TokenType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_TokenType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a TokenType object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $tokenType = new TokenType(
            'urn:some:uri',
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($tokenType),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $tokenType = new TokenType();
        $this->assertTrue($tokenType->isEmptyElement());
    }
}
