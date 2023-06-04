<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsu;

use DateTimeImmutable;
use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsu\Created;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsu:Created.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsu\Created
 * @covers \SimpleSAML\WSSecurity\XML\wsu\AbstractAttributedDateTime
 * @covers \SimpleSAML\WSSecurity\XML\wsu\AbstractWsuElement
 * @package tvdijen/ws-security
 */
final class CreatedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Created::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/oasis-200401-wss-wssecurity-utility-1.0.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsu_Created.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an Created object from scratch.
     */
    public function testMarshalling(): void
    {
        $created = new Created(new DateTimeImmutable('2001-09-13T08:42:00Z'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($created)
        );
    }


    // test unmarshalling


    /**
     * Test creating a Created from XML.
     */
    public function testUnmarshalling(): void
    {
        $created = Created::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($created)
        );
    }
}