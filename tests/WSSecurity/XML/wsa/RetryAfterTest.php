<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\WSSecurity\XML\wsa\RetryAfter;
use SimpleSAML\XML\DOMDocumentFactory;

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
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = RetryAfter::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wsa_RetryAfter.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an RetryAfter object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test');
        $attr1->value = 'value';

        $retryAfter = new RetryAfter('1234567890', [$attr1]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($retryAfter)
        );
    }


    // test unmarshalling


    /**
     * Test creating a RetryAfter from XML.
     */
    public function testUnmarshalling(): void
    {
        $RetryAfter = RetryAfter::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($RetryAfter)
        );
    }
}
