<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsaw;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsaw\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsaw\AbstractAttributedQNameType;
use SimpleSAML\WSSecurity\XML\wsaw\InterfaceName;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsaw\InterfaceNameTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsaw')]
#[CoversClass(InterfaceName::class)]
#[CoversClass(AbstractQNameAttributedQNameType::class)]
#[CoversClass(AbstractWsawElement::class)]
final class InterfaceNameTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = InterfaceName::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr-wsdl.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsaw_InterfaceName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a InterfaceName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $interfaceName = new InterfaceName('ssp:Chunk', [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($interfaceName),
        );
    }
}
