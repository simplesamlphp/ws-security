<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\EndpointReference;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for wsa:EndpointReference.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\EndpointReference
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractMdElement
 * @package tvdijen/ws-security
 */
final class EndpointReferenceTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = EndpointReference::class;

        $this->xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wsa_EndpointReference.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an EndpointReference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:attr');
        $attr1->value = 'value';
        $attr2 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test');
        $attr2->value = 'value';

        $endpointReference = new EndpointReference(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [],
            [],
            [],
            [$attr1],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($endpointReference)
        );
    }


    // test unmarshalling


    /**
     * Test creating a EndpointReference from XML.
     */
    public function testUnmarshalling(): void
    {
        $endpointReference = EndpointReference::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($endpointReference)
        );
    }
}

