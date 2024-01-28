<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst\BinarySecret;
use SimpleSAML\WSSecurity\XML\wst\BinarySecretTypeEnum;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\BinarySecretTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\BinarySecret
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractBinarySecretType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package simplesamlphp/ws-security
 */
final class BinarySecretTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = BinarySecret::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_BinarySecret.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a BinarySecret object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');

        $binarySecret = new BinarySecret(
            '/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=',
            [BinarySecretTypeEnum::Nonce],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binarySecret),
        );
    }
}
