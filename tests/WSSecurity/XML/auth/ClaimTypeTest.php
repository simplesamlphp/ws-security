<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\auth\{
    AbstractAuthElement,
    AbstractClaimType,
    ClaimType,
    Description,
    DisplayName,
    DisplayValue,
    Value,
};
use SimpleSAML\XML\{Attribute as XMLAttribute, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\{AnyURIValue, BooleanValue, StringValue};

use function dirname;
use function strval;

/**
 * Tests for auth:ClaimType.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ClaimType::class)]
#[CoversClass(AbstractClaimType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ClaimTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ClaimType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ClaimType object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimType),
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr],
        );
        $claimTypeElement = $claimType->toXML();

        // Test for a DisplayName
        $xpCache = XPath::getXPath($claimTypeElement);
        $claimTypeElements = XPath::xpQuery($claimTypeElement, './auth:DisplayName', $xpCache);
        $this->assertCount(1, $claimTypeElements);

        // Test ordering of ClaimType contents
        /** @psalm-var \DOMElement[] $claimTypeElements */
        $claimTypeElements = XPath::xpQuery($claimTypeElement, './auth:DisplayName/following-sibling::*', $xpCache);
        $this->assertCount(3, $claimTypeElements);
        $this->assertEquals('auth:Description', $claimTypeElements[0]->tagName);
        $this->assertEquals('auth:DisplayValue', $claimTypeElements[1]->tagName);
        $this->assertEquals('auth:Value', $claimTypeElements[2]->tagName);
    }
}
