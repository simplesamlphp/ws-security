<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\Attachments;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\AttachmentsTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\Attachments
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractEmptyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class AttachmentsTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Attachments::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_Attachments.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an Attachments from scratch works.
     */
    public function testMarshalling(): void
    {
        $attachments = new Attachments();

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($attachments),
        );
    }


    // test unmarshalling


    /**
     * Test that creating an Attachments from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $attachments = Attachments::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($attachments),
        );
    }
}
