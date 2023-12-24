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
 * Class \SimpleSAML\WSSecurity\XML\sp\QNameAssertionTypeTestTrait
 *
 * @package tvdijen/ws-security
 */
trait NestedPolicyTypeTestTrait
{
    // test marshalling


    /**
     * Test that creating a QNameAssertionType from scratch works.
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
     * Adding an empty InitiatorToken element should yield an empty element.
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
}
