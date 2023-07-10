<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsse\Username;
use SimpleSAML\WSSecurity\XML\wsse\UsernameToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:UsernameToken.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsse\UsernameToken
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractUsernameTokenType
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement
 * @package tvdijen/ws-security
 */
final class UsernameTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = UsernameToken::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/oasis-200401-wss-wssecurity-secext-1.0.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_UsernameToken.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a UsernameToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $username = new Username('johndoe@example.com', 'OtherID', [$attr2]);
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $usernameToken = new UsernameToken(
            $username,
            'SomeID',
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($usernameToken),
        );
    }


    // test unmarshalling


    /**
     * Test creating a UsernameToken from XML.
     */
    public function testUnmarshalling(): void
    {
        $usernameToken = UsernameToken::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($usernameToken),
        );
    }
}