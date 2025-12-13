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
use SimpleSAML\WSSecurity\XML\wsa_200408\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsa_200408\PortType;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceParameters;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceProperties;
use SimpleSAML\WSSecurity\XML\wsa_200408\ServiceName;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsa:EndpointReference.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(EndpointReference::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class EndpointReferenceTest extends TestCase
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
        self::$testedClass = EndpointReference::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/EndpointReference.xml',
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
     * Test creating an EndpointReference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', StringValue::fromString('value1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', StringValue::fromString('value2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', StringValue::fromString('value3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', StringValue::fromString('value4'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType(QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'), [$attr3]);
        $serviceName = new ServiceName(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
            NCNameValue::fromString('PHPUnit'),
            [$attr4],
        );
        $chunk = new Chunk(self::$customContent);

        $endpointReference = new EndpointReference(
            new Address(AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'), [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($endpointReference),
        );
    }


    /**
     * Test element order.
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', StringValue::fromString('value1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', StringValue::fromString('value2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', StringValue::fromString('value3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', StringValue::fromString('value4'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType(QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'), [$attr3]);
        $serviceName = new ServiceName(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
            NCNameValue::fromString('PHPUnit'),
            [$attr4],
        );
        $chunk = new Chunk(self::$customContent);

        $endpointReference = new EndpointReference(
            new Address(AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'), [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr1],
        );

        // Test for an Address
        $endpointReferenceElement = $endpointReference->toXML();
        $xpCache = XPath::getXPath($endpointReferenceElement);
        $endpointReferenceElements = XPath::xpQuery($endpointReferenceElement, './wsa:Address', $xpCache);
        $this->assertCount(1, $endpointReferenceElements);

        // Test ordering of EndpointReference contents
        /** @var \DOMElement[] $endpointReferenceElements */
        $endpointReferenceElements = XPath::xpQuery(
            $endpointReferenceElement,
            './wsa:Address/following-sibling::*',
            $xpCache,
        );

        $this->assertCount(5, $endpointReferenceElements);
        $this->assertEquals('wsa:ReferenceProperties', $endpointReferenceElements[0]->tagName);
        $this->assertEquals('wsa:ReferenceParameters', $endpointReferenceElements[1]->tagName);
        $this->assertEquals('wsa:PortType', $endpointReferenceElements[2]->tagName);
        $this->assertEquals('wsa:ServiceName', $endpointReferenceElements[3]->tagName);
        $this->assertEquals('ssp:Chunk', $endpointReferenceElements[4]->tagName);
    }
}
