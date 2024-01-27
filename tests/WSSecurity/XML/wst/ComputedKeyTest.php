<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\ComputedKey;
use SimpleSAML\WSSecurity\XML\wst\ComputedKeyEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\ComputedKeyTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ComputedKey
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractComputedKeyOpenEnum
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class ComputedKeyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = ComputedKey::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_ComputedKey.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ComputedKey object from scratch.
     */
    public function testMarshalling(): void
    {
        $computedKey = new ComputedKey([ComputedKeyEnum::PSHA1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($computedKey),
        );
    }
}
