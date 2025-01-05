<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\CanonicalizationAlgorithm;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\CanonicalizationAlgorithmTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(CanonicalizationAlgorithm::class)]
#[CoversClass(AbstractWstElement::class)]
final class CanonicalizationAlgorithmTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = CanonicalizationAlgorithm::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/CanonicalizationAlgorithm.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a CanonicalizationAlgorithm object from scratch.
     */
    public function testMarshalling(): void
    {
        $canonicalizationAlgorithm = new CanonicalizationAlgorithm(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($canonicalizationAlgorithm),
        );
    }
}
