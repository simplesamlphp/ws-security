<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\{AbstractAssertionType, AbstractFedElement, ReferenceToken11};
use SimpleSAML\XML\{Attribute as XMLAttribute, Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ReferenceToken11Test
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(ReferenceToken11::class)]
#[CoversClass(AbstractAssertionType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ReferenceToken11Test extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;

    /** @var \SimpleSAML\XML\Attribute $attr */
    protected static XMLAttribute $attr;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceToken11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceToken11.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating a ReferenceToken11 object from scratch.
     */
    public function testMarshalling(): void
    {
        $referenceToken11 = new ReferenceToken11(
            [self::$chunk],
            [self::$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceToken11),
        );
    }


    /**
     * Adding an empty X509lToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $fedns = C::NS_FED;
        $referenceToken11 = new ReferenceToken11();
        $this->assertEquals(
            "<fed:ReferenceToken11 xmlns:fed=\"$fedns\"/>",
            strval($referenceToken11),
        );
        $this->assertTrue($referenceToken11->isEmptyElement());
    }
}
