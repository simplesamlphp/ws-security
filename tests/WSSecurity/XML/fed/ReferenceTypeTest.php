<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\{
    AbstractAttributeExtensibleString,
    AbstractAttributeExtensibleURI,
    AbstractFedElement,
    ReferenceType,
};
use SimpleSAML\XML\{Attribute as XMLAttribute, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\{AnyURIValue, StringValue};

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ReferenceTypeTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(ReferenceType::class)]
#[CoversClass(AbstractAttributeExtensibleURI::class)]
#[CoversClass(AbstractAttributeExtensibleString::class)]
#[CoversClass(AbstractFedElement::class)]
final class ReferenceTypeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ReferenceType object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $referenceType = new ReferenceType(AnyURIValue::fromString(C::NAMESPACE), [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceType),
        );
    }
}
