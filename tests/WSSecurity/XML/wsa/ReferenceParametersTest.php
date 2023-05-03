<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsa\ReferenceParametersTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 *
 * @package tvdijen/ws-security
 */
final class ReferenceParametersTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $referenceParametersContent */
    private DOMElement $referenceParametersContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = ReferenceParameters::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ReferenceParameters.xml'
        );

        $this->referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $referenceParameters = new ReferenceParameters([new Chunk($this->referenceParametersContent)], [$domAttr]);
        $this->assertFalse($referenceParameters->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($referenceParameters)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $referenceParameters = new ReferenceParameters([], []);
        $this->assertEquals(
            '<wsa:ReferenceParameters xmlns:wsa="http://www.w3.org/2005/08/addressing"/>',
            strval($referenceParameters)
        );
        $this->assertTrue($referenceParameters->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $referenceParameters = ReferenceParameters::fromXML($this->xmlRepresentation->documentElement);

        $elements = $referenceParameters->getElements();
        $this->assertFalse($referenceParameters->isEmptyElement());
        $this->assertCount(1, $elements);

        $attributes = $referenceParameters->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = end($attributes);
        $this->assertEquals('test:attr1', $attribute['qualifiedName']);
        $this->assertEquals('urn:test:something', $attribute['namespaceURI']);
        $this->assertEquals('testval1', $attribute['value']);
    }
}
