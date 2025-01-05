<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractBinarySecretType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\BinarySecret;
use SimpleSAML\WSSecurity\XML\wst_200512\BinarySecretTypeEnum;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\BinarySecretTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(BinarySecret::class)]
#[CoversClass(AbstractBinarySecretType::class)]
#[CoversClass(AbstractWstElement::class)]
final class BinarySecretTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = BinarySecret::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/BinarySecret.xml',
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
