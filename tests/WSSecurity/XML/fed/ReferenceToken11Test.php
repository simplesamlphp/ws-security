<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\ReferenceToken11;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ReferenceToken11Test
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\ReferenceToken11
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAssertionType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
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
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = ReferenceToken11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceToken11.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
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
}
