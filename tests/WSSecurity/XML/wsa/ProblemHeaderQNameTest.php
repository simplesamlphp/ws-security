<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\ProblemHeaderQName;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\ProblemHeaderQName
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedQNameType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class ProblemHeaderQNameTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ProblemHeaderQName::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ProblemHeaderQName.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemHeaderQName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'value1');

        $problemHeaderQName = new ProblemHeaderQName('wsa:Action', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($problemHeaderQName)
        );
    }
}
