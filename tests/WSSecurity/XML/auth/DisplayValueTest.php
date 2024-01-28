<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\DisplayValue;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:DisplayValue.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\DisplayValue
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractDisplayValueType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package simplesamlphp/ws-security
 */
final class DisplayValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = DisplayValue::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_DisplayValue.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an DisplayValue object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $displayValue = new DisplayValue('MyValue', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($displayValue)
        );
    }
}
