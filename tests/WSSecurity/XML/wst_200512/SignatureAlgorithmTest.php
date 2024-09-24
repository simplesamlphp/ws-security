<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\SignatureAlgorithm;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\SignatureAlgorithmTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(SignatureAlgorithm::class)]
#[CoversClass(AbstractWstElement::class)]
final class SignatureAlgorithmTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200512.xsd';

        self::$testedClass = SignatureAlgorithm::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/SignatureAlgorithm.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SignatureAlgorithm object from scratch.
     */
    public function testMarshalling(): void
    {
        $signatureAlgorithm = new SignatureAlgorithm(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signatureAlgorithm),
        );
    }
}
