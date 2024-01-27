<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\KeyType;
use SimpleSAML\WSSecurity\XML\wst\KeyTypeEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\KeyTypeTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\KeyType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractKeyTypeOpenEnum
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class KeyTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = KeyType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_KeyType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a KeyType object from scratch.
     */
    public function testMarshalling(): void
    {
        $keyType = new KeyType([KeyTypeEnum::PublicKey]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($keyType),
        );
    }
}
