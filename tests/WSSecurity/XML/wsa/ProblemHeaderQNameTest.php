<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wsa\ProblemHeaderQName;
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
    protected function setUp(): void
    {
        $this->testedClass = ProblemHeaderQName::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ProblemHeaderQName.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemHeaderQName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:attr1');
        $attr1->value = 'value1';

        $problemHeaderQName = new ProblemHeaderQName('wsa:Action', [$attr1]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemHeaderQName)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ProblemHeaderQName from XML.
     */
    public function testUnmarshalling(): void
    {
        $problemHeaderQName = ProblemHeaderQName::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemHeaderQName)
        );
    }
}
