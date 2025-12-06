<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\AbstractUsernameTokenType;
use SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement;
use SimpleSAML\WSSecurity\XML\wsse\Username;
use SimpleSAML\WSSecurity\XML\wsse\UsernameToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:UsernameToken.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsse')]
#[CoversClass(UsernameToken::class)]
#[CoversClass(AbstractUsernameTokenType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class UsernameTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = UsernameToken::class;

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
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
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
}
