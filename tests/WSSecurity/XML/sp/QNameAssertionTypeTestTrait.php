<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\Attribute as XMLAttribute;

use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\QNameAssertionTypeTestTrait
 *
 * @package tvdijen/ws-security
 */
trait QNameAssertionTypeTestTrait
{
    // test marshalling


    /**
     * Test that creating a QNameAssertionType from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $qns = new static::$testedClass([$attr]);

        $this->assertEquals(
            static::$xmlRepresentation->saveXML(static::$xmlRepresentation->documentElement),
            strval($qns),
        );
    }


    /**
     * Test that creating a QNameAssertionType from scratch without attributes works.
     */
    public function testMarshallingWithoutNSAttr(): void
    {
        $xmlRepresentation = clone static::$xmlRepresentation;
        $xmlRepresentation->documentElement->removeAttributeNS(C::NAMESPACE, 'attr1');
        $xmlRepresentation->documentElement->removeAttributeNS(C::NAMESPACE, 'ssp');

        $qns = new static::$testedClass();

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($qns),
        );
    }


    // test unmarshalling


    /**
     * Test that creating a QNameAssertionType from XML without attributes succeeds.
     */
    public function testUnmarshallingWithoutNSAttr(): void
    {
        $xmlRepresentation = clone static::$xmlRepresentation;
        $xmlRepresentation->documentElement->removeAttributeNS(C::NAMESPACE, 'attr1');
        $xmlRepresentation->documentElement->removeAttributeNS(C::NAMESPACE, 'ssp');

        $qna = static::$testedClass::fromXML($xmlRepresentation->documentElement);

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($qna),
        );
    }
}
