<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200408;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200408\Address;
use SimpleSAML\WSSecurity\XML\wsa_200408\FaultTo;
use SimpleSAML\WSSecurity\XML\wsa_200408\PortType;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceParameters;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceProperties;
use SimpleSAML\WSSecurity\XML\wsa_200408\ServiceName;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:FaultTo.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(FaultTo::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class FaultToTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \DOMElement $referencePropertiesContent */
    protected static DOMElement $referencePropertiesContent;

    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultTo::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/FaultTo.xml',
        );

        self::$referencePropertiesContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an FaultTo object FaultTo scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', 'value1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', 'value3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', 'value4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType('ssp:Chunk', [$attr3]);
        $serviceName = new ServiceName('ssp:Chunk', 'PHPUnit', [$attr4]);
        $chunk = new Chunk(self::$customContent);

        $FaultTo = new FaultTo(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($FaultTo),
        );
    }


    /**
     * Test element order.
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', 'value1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', 'value2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', 'value3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', 'value4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType('ssp:Chunk', [$attr3]);
        $serviceName = new ServiceName('ssp:Chunk', 'PHPUnit', [$attr4]);
        $chunk = new Chunk(self::$customContent);

        $FaultTo = new FaultTo(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr1],
        );

        // Test for an Address
        $FaultToElement = $FaultTo->toXML();
        $xpCache = XPath::getXPath($FaultToElement);
        $FaultToElements = XPath::xpQuery($FaultToElement, './wsa:Address', $xpCache);
        $this->assertCount(1, $FaultToElements);

        // Test ordering of FaultTo contents
        /** @psalm-var \DOMElement[] $FaultToElements */
        $FaultToElements = XPath::xpQuery($FaultToElement, './wsa:Address/following-sibling::*', $xpCache);
        $this->assertCount(5, $FaultToElements);
        $this->assertEquals('wsa:ReferenceProperties', $FaultToElements[0]->tagName);
        $this->assertEquals('wsa:ReferenceParameters', $FaultToElements[1]->tagName);
        $this->assertEquals('wsa:PortType', $FaultToElements[2]->tagName);
        $this->assertEquals('wsa:ServiceName', $FaultToElements[3]->tagName);
        $this->assertEquals('ssp:Chunk', $FaultToElements[4]->tagName);
    }
}
