<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement;
use SimpleSAML\WSSecurity\XML\wsx\Location;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsx\LocationTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsx')]
#[CoversClass(Location::class)]
#[CoversClass(AbstractWsxElement::class)]
final class LocationTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/MetadataExchange.xsd';

        self::$testedClass = Location::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_Location.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Location object from scratch.
     */
    public function testMarshalling(): void
    {
        $location = new Location(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($location),
        );
    }
}
