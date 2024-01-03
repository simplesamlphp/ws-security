<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\SerialNo;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\SerialNoTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\SerialNo
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleURI
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleString
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
final class SerialNoTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SerialNo::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_SerialNo.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SerialNo object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $serialNo = new SerialNo(C::NAMESPACE, [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($serialNo),
        );
    }
}
