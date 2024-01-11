<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\XML\Attribute;
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
    private static DOMElement $referenceParametersContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceParameters::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ReferenceParameters.xml'
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', 'testval1');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$domAttr]);
        $this->assertFalse($referenceParameters->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
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
}
