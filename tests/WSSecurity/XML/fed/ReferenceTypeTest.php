<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\ReferenceType;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ReferenceTypeTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\ReferenceType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleURI
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleString
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
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
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $referenceType = new ReferenceType(C::NAMESPACE, [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceType),
        );
    }
}
