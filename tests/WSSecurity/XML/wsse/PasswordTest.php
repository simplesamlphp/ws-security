<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\Password;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:Password.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsse\Password
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractPasswordString
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractAttributedString
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement
 * @package simplesamlphp/ws-security
 */
final class PasswordTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Password::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_Password.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Password object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $password = new Password('secret', 'SomeID', 'SomeType', [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($password),
        );
    }
}
