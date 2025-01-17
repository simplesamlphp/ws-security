<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\CombinedHash;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\CombinedHashTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(CombinedHash::class)]
#[CoversClass(AbstractWstElement::class)]
final class CombinedHashTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = CombinedHash::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/CombinedHash.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a CombinedHash object from scratch.
     */
    public function testMarshalling(): void
    {
        $combinedHash = new CombinedHash('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($combinedHash),
        );
    }
}
