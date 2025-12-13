<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsaw;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsaw\AbstractWsawElement;
use SimpleSAML\WSSecurity\XML\wsaw\UsingAddressing;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsaw\UsingAddressingTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsaw')]
#[CoversClass(UsingAddressing::class)]
#[CoversClass(AbstractWsawElement::class)]
final class UsingAddressingTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = UsingAddressing::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsaw_UsingAddressing.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a UsingAddressing object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $usingAddressing = new UsingAddressing([$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($usingAddressing),
        );
    }
}
