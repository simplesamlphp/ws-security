<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsx\Dialect;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsx\DialectTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsx\Dialect
 * @covers \SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement
 *
 * @package tvdijen/ws-security
 */
final class DialectTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/MetadataExchange.xsd';

        self::$testedClass = Dialect::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_Dialect.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Dialect object from scratch.
     */
    public function testMarshalling(): void
    {
        $dialect = new Dialect(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($dialect),
        );
    }
}
