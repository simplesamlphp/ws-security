<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\From;
use SimpleSAML\WSSecurity\XML\wsa\Metadata;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:From.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\From
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class FromTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \DOMElement $referenceParametersContent */
    protected DOMElement $referenceParametersContent;

    /** @var \DOMElement $metadataContent */
    protected DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected DOMElement $customContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = From::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_From.xml'
        );

        $this->referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>'
        )->documentElement;

        $this->metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;

        $this->customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>'
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an From object from scratch.
     */
    public function testMarshalling(): void
    {
        $doc = DOMDocumentFactory::fromString('<root/>');

        $attr1 = $doc->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test1');
        $attr1->value = 'value1';
        $attr2 = $doc->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test2');
        $attr2->value = 'value2';
        $attr3 = $doc->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test3');
        $attr3->value = 'value3';
        $attr4 = $doc->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test4');
        $attr4->value = 'value4';

        $referenceParameters = new ReferenceParameters([new Chunk($this->referenceParametersContent)], [$attr4]);
        $metadata = new Metadata([new Chunk($this->metadataContent)], [$attr3]);
        $chunk = new Chunk($this->customContent);

        $from = new From(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [$referenceParameters],
            [$metadata],
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($from)
        );
    }


    // test unmarshalling


    /**
     * Test creating a From from XML.
     */
    public function testUnmarshalling(): void
    {
        $from = From::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($from)
        );
    }
}
