<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:Value.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(Value::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Value::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_Value.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Value object from scratch.
     */
    public function testMarshalling(): void
    {
        $value = new Value('MyValue');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($value),
        );
    }
}
