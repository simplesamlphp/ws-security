<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SerializableXMLTestTrait;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wsa\ProblemIRI;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\ProblemIRI
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractMdElement
 * @package tvdijen/ws-security
 */
final class ProblemIRITest extends TestCase
{
    use SerializableXMLTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = ProblemIRI::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wsa_ProblemIRI.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemIRI object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS(Constants::NS_SOAP, 'soapenv:mustUnderstand');
        $attr1->value = '1';

        $problemIri = new ProblemIRI('https://login.microsoftonline.com/login.srf', [$attr1]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemIri)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ProblemIRI from XML.
     */
    public function testUnmarshalling(): void
    {
        $problemIri = ProblemIRI::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemIri)
        );
    }
}

