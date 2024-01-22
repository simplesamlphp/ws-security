<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\Freshness;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\FreshnessTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\Freshness
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFreshnessType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
final class FreshnessTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Attribute $attr */
    protected static XMLAttribute $attr;

    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = Freshness::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_Freshness.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Freshness object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $freshness = new Freshness(123, true, [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($freshness),
        );
    }
}
