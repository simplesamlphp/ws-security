<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsaw;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsaw\AbstractAnonymousType;
use SimpleSAML\WSSecurity\XML\wsaw\AbstractWsawElement;
use SimpleSAML\WSSecurity\XML\wsaw\Anonymous;
use SimpleSAML\WSSecurity\XML\wsaw\AnonymousEnum;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsaw\AnonymousTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsaw')]
#[CoversClass(Anonymous::class)]
#[CoversClass(AnonymousEnum::class)]
#[CoversClass(AbstractAnonymousType::class)]
#[CoversClass(AbstractWsawElement::class)]
final class AnonymousTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Anonymous::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr-wsdl.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsaw_Anonymous.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Anonymous object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $anonymous = new Anonymous(AnonymousEnum::Prohibited, [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($anonymous),
        );
    }
}
