<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\{AbstractAuthElement, AbstractDisplayNameType, DisplayName};
use SimpleSAML\XML\{Attribute, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:DisplayName.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(DisplayName::class)]
#[CoversClass(AbstractDisplayNameType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class DisplayNameTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = DisplayName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_DisplayName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an DisplayName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $displayName = new DisplayName(StringValue::fromString('MyFancyDisplayName'), [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($displayName),
        );
    }
}
