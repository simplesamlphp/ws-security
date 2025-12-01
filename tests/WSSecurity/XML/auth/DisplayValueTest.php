<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement;
use SimpleSAML\WSSecurity\XML\auth\AbstractDisplayValueType;
use SimpleSAML\WSSecurity\XML\auth\DisplayValue;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:DisplayValue.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(DisplayValue::class)]
#[CoversClass(AbstractDisplayValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class DisplayValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = DisplayValue::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_DisplayValue.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an DisplayValue object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $displayValue = new DisplayValue(StringValue::fromString('MyValue'), [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($displayValue),
        );
    }
}
