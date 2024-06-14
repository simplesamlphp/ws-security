<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsu;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsu\AbstractAttributedDateTime;
use SimpleSAML\WSSecurity\XML\wsu\AbstractWsuElement;
use SimpleSAML\WSSecurity\XML\wsu\Expires;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsu:Expires.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(Expires::class)]
#[CoversClass(AbstractAttributedDateTime::class)]
#[CoversClass(AbstractWsuElement::class)]
final class ExpiresTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Expires::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/oasis-200401-wss-wssecurity-utility-1.0.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsu_Expires.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Expires object from scratch.
     */
    public function testMarshalling(): void
    {
        $expires = new Expires(new DateTimeImmutable('2001-10-13T09:00:00Z'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($expires),
        );
    }
}
