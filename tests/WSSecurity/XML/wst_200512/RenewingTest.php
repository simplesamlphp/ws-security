<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractRenewingType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\Renewing;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\RenewingTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Renewing::class)]
#[CoversClass(AbstractRenewingType::class)]
#[CoversClass(AbstractWstElement::class)]
final class RenewingTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Renewing::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/Renewing.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Renewing object from scratch.
     */
    public function testMarshalling(): void
    {
        $renewing = new Renewing(true, false);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($renewing),
        );
    }


    /**
     * Test creating an empty Renewing object from scratch.
     */
    public function testMarshallingEmpty(): void
    {
        $renewing = new Renewing();

        $this->assertTrue($renewing->isEmptyElement());
    }
}
