<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\ReferenceParameters;
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
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(ReferenceParameters::class)]
#[CoversClass(AbstractWsaElement::class)]
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

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/ReferenceParameters.xml',
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
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
            strval($referenceParameters),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $referenceParameters = new ReferenceParameters([], []);
        $this->assertEquals(
            '<wsa10:ReferenceParameters xmlns:wsa10="http://www.w3.org/2005/08/addressing"/>',
            strval($referenceParameters),
        );
        $this->assertTrue($referenceParameters->isEmptyElement());
    }
}
