<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst\AllowPostdating;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\AllowPostdatingTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(AllowPostdating::class)]
#[CoversClass(AbstractWstElement::class)]
final class AllowPostdatingTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = AllowPostdating::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_AllowPostdating.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a AllowPostdating object from scratch.
     */
    public function testMarshalling(): void
    {
        $allowPostdating = new AllowPostdating();

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($allowPostdating),
        );
    }


    /**
     * Test creating an empty AllowPostdating object from scratch.
     *
     * NOTE: This element is empty per definition!
     */
    public function testMarshallingEmpty(): void
    {
        $allowPostdating = new AllowPostdating();
        $this->assertFalse($allowPostdating->isEmptyElement());
    }
}
