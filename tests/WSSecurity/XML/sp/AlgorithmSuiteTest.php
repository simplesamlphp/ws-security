<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\AlgorithmSuite;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\AlgorithmSuiteTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\AlgorithmSuite
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractNestedPolicyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class AlgorithmSuiteTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = AlgorithmSuite::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_AlgorithmSuite.xml',
        );
    }


    /**
     * Adding an empty AlgorithmSuite element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $algorithmSuite = new AlgorithmSuite();
        $this->assertEquals(
            "<sp:AlgorithmSuite xmlns:sp=\"$spns\"/>",
            strval($algorithmSuite),
        );
        $this->assertTrue($algorithmSuite->isEmptyElement());
    }


    // test marshalling


    /**
     * Test that creating a AlgorithmSuite from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $algorithmSuite = new AlgorithmSuite([$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($algorithmSuite),
        );
    }


    // test unmarshalling


    /**
     * Test that creating a AlgorithmSuite from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $algorithmSuite = AlgorithmSuite::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($algorithmSuite),
        );
    }
}
