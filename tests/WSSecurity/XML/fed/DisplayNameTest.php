<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\DisplayName;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\DisplayNameTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\DisplayName
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleString
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package simplesamlphp/ws-security
 */
final class DisplayNameTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = DisplayName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_DisplayName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a DisplayName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $DisplayName = new DisplayName('phpunit', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($DisplayName),
        );
    }
}
