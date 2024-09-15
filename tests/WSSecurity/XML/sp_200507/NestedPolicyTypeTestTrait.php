<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\NestedPolicyTypeTestTrait
 *
 * @package simplesamlphp/ws-security
 */
trait NestedPolicyTypeTestTrait
{
    // test marshalling


    /**
     * Test that creating a NestedPolicyType from scratch works.
     */
    public function testMarshalling(): void
    {
        $np = new static::$testedClass([static::$policy, static::$some], [static::$attr]);
        $this->assertEquals(
            static::$xmlRepresentation->saveXML(static::$xmlRepresentation->documentElement),
            strval($np),
        );
    }
}
