<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\FaultTo;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for wsa:FaultTo.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\FaultTo
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class FaultToTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = FaultTo::class;

        $this->xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wsa_FaultTo.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an FaultTo object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:attr');
        $attr1->value = 'value';
        $attr2 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test');
        $attr2->value = 'value';

        $faultTo = new FaultTo(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [],
            [],
            [],
            [$attr1],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultTo)
        );
    }


    // test unmarshalling


    /**
     * Test creating a FaultTo from XML.
     */
    public function testUnmarshalling(): void
    {
        $faultTo = FaultTo::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultTo)
        );
    }
}
