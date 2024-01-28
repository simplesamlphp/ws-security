<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\TokenType;
use SimpleSAML\WSSecurity\XML\fed\TokenTypesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:TokenTypesOffered.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\TokenTypesOffered
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractTokenTypesOfferedType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package simplesamlphp/ws-security
 */
final class TokenTypesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TokenTypesOffered::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_TokenTypesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a TokenTypesOffered object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $child1 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $child2 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OtherChunk</ssp:Chunk>',
        );

        $tokenType = new TokenType(
            'urn:some:uri',
            [new Chunk($child1->documentElement)],
            [$attr2],
        );

        $tokenTypesOffered = new TokenTypesOffered(
            [$tokenType],
            [new Chunk($child2->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($tokenTypesOffered),
        );
    }
}
