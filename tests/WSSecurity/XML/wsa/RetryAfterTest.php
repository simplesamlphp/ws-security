<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\XML\wsa\RetryAfter;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:RetryAfter.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\RetryAfter
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedLongType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class RetryAfterTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RetryAfter::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_RetryAfter.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an RetryAfter object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', 'value');
        $retryAfter = new RetryAfter('1234567890', [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($retryAfter)
        );
    }


    // test unmarshalling


    /**
     * Test creating a RetryAfter from XML.
     */
    public function testUnmarshalling(): void
    {
        $RetryAfter = RetryAfter::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($RetryAfter)
        );
    }
}
