<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function sprintf;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\NestedPolicyTypeTestTrait
 *
 * @package tvdijen/ws-security
 */
trait NestedPolicyTypeTestTrait
{
    // test marshalling


    /**
     * Test that creating a NestedPolicyType from scratch works.
     */
    public function testMarshalling(): void
    {
        $np = new static::$testedClass([static::$chunk], [static::$attr]);

        $this->assertEquals(
            static::$xmlRepresentation->saveXML(static::$xmlRepresentation->documentElement),
            strval($np),
        );
    }


    /**
     * Test that creating a NestedPolicyType from scratch without attributes works.
     */
    public function testMarshallingWithoutNSAttr(): void
    {
        $xml = <<<XML
<sp:%s xmlns:sp="%s">
  <ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>
</sp:%s>
XML;
        $localName = static::$testedClass::getLocalName();
        $xml = sprintf($xml, $localName, C::NS_SEC_POLICY, $localName);
        $xmlRepresentation = DOMDocumentFactory::fromString($xml);

        $np = new static::$testedClass([static::$chunk]);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($np),
        );
    }


    /**
     * Test that creating a NestedPolicyType from scratch without children works.
     */
    public function testMarshallingWithoutChildren(): void
    {
        $xml = '<sp:%s xmlns:sp="%s" xmlns:ssp="urn:x-simplesamlphp:namespace" ssp:attr1="value1"/>';
        $localName = static::$testedClass::getLocalName();
        $xml = sprintf($xml, $localName, C::NS_SEC_POLICY, $localName);
        $xmlRepresentation = DOMDocumentFactory::fromString($xml);

        $qns = new static::$testedClass([], [static::$attr]);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($qns),
        );
    }


    /**
     * Adding an empty NestedPolicyType element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $np = new static::$testedClass();
        $this->assertEquals(
            sprintf("<sp:%s xmlns:sp=\"%s\"/>", static::$testedClass::getLocalName(), C::NS_SEC_POLICY),
            strval($np),
        );
        $this->assertTrue($np->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating a NestedPolicyType from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $np = static::$testedClass::fromXML(static::$xmlRepresentation->documentElement);

        $this->assertEquals(
            static::$xmlRepresentation->saveXML(static::$xmlRepresentation->documentElement),
            strval($np),
        );
    }


    /**
     * Test that creating a NestedPolicyType from XML without attributes succeeds.
     */
    public function testUnmarshallingWithoutNSAttr(): void
    {
        $xml = <<<XML
<sp:%s xmlns:sp="%s">
  <ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>
</sp:%s>
XML;
        $localName = static::$testedClass::getLocalName();
        $xml = sprintf($xml, $localName, C::NS_SEC_POLICY, $localName);
        $xmlRepresentation = DOMDocumentFactory::fromString($xml);

        $np = static::$testedClass::fromXML($xmlRepresentation->documentElement);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($np),
        );
    }


    /**
     * Test that creating a NestedPolicyType from XML without children succeeds.
     */
    public function testUnmarshallingWithoutChildren(): void
    {
        $xml = '<sp:%s xmlns:sp="%s" xmlns:ssp="urn:x-simplesamlphp:namespace" ssp:attr1="value1"/>';
        $localName = static::$testedClass::getLocalName();
        $xml = sprintf($xml, $localName, C::NS_SEC_POLICY, $localName);
        $xmlRepresentation = DOMDocumentFactory::fromString($xml);

        $np = static::$testedClass::fromXML($xmlRepresentation->documentElement);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($np),
        );
    }
}
