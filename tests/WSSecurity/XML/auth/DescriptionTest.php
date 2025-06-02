<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\{AbstractAuthElement, AbstractDescriptionType, Description};
use SimpleSAML\XML\{Attribute, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:Description.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(Description::class)]
#[CoversClass(AbstractDescriptionType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class DescriptionTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Description::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_Description.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Description object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $description = new Description(StringValue::fromString('MyDescription'), [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($description),
        );
    }
}
