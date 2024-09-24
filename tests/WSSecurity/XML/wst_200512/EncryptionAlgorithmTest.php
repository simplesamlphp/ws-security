<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\EncryptionAlgorithm;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\EncryptionAlgorithmTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(EncryptionAlgorithm::class)]
#[CoversClass(AbstractWstElement::class)]
final class EncryptionAlgorithmTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200512.xsd';

        self::$testedClass = EncryptionAlgorithm::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/EncryptionAlgorithm.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a EncryptionAlgorithm object from scratch.
     */
    public function testMarshalling(): void
    {
        $encryptionAlgorithm = new EncryptionAlgorithm(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($encryptionAlgorithm),
        );
    }
}
