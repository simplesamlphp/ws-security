<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Addressing\XML\wsa_200408\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200408\PortType;
use SimpleSAML\WebServices\Addressing\XML\wsa_200408\ReferenceParameters;
use SimpleSAML\WebServices\Addressing\XML\wsa_200408\ReferenceProperties;
use SimpleSAML\WebServices\Addressing\XML\wsa_200408\ServiceName;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSecureConversationTokenType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200507\Issuer;
use SimpleSAML\WSSecurity\XML\sp_200507\SecureConversationToken;
use SimpleSAML\WSSecurity\XML\sp_200507\Type\IncludeTokenValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\SecureConversationTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(SecureConversationToken::class)]
#[CoversClass(AbstractSecureConversationTokenType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SecureConversationTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \DOMElement $referencePropertiesContent */
    protected static DOMElement $referencePropertiesContent;

    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SecureConversationToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/SecureConversationToken.xml',
        );

        self::$referencePropertiesContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', StringValue::fromString('value2'));
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', StringValue::fromString('value3'));
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', StringValue::fromString('value4'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType(QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'), [$attr3]);
        $serviceName = new ServiceName(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
            NCNameValue::fromString('PHPUnit'),
            [$attr4],
        );

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $issuer = new Issuer(
            new Address(AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'), [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr2],
        );

        $secureConversationToken = new SecureConversationToken(
            $issuer,
            IncludeTokenValue::fromEnum(IncludeToken::Always),
            [$chunk],
            [$attr1],
        );
        $secureConversationTokenElement = $secureConversationToken->toXML();

        // Test for a Issuer
        $xpCache = XPath::getXPath($secureConversationTokenElement);
        $secureConversationTokenElements = XPath::xpQuery($secureConversationTokenElement, './sp:Issuer', $xpCache);
        $this->assertCount(1, $secureConversationTokenElements);

        // Test ordering of SecureConversationToken contents
        /** @var \DOMElement[] $secureConversationTokenElements */
        $secureConversationTokenElements = XPath::xpQuery(
            $secureConversationTokenElement,
            './sp:Issuer/following-sibling::*',
            $xpCache,
        );

        $this->assertCount(1, $secureConversationTokenElements);
        $this->assertEquals('ssp:Chunk', $secureConversationTokenElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a SecureConversationToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test2', StringValue::fromString('value2'));
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test3', StringValue::fromString('value3'));
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'test4', StringValue::fromString('value4'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)]);
        $referenceProperties = new ReferenceProperties([new Chunk(self::$referencePropertiesContent)]);

        $portType = new PortType(QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'), [$attr3]);
        $serviceName = new ServiceName(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
            NCNameValue::fromString('PHPUnit'),
            [$attr4],
        );

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $issuer = new Issuer(
            new Address(AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'), [$attr2]),
            $referenceProperties,
            $referenceParameters,
            $portType,
            $serviceName,
            [$chunk],
            [$attr2],
        );

        $secureConversationToken = new SecureConversationToken(
            $issuer,
            IncludeTokenValue::fromEnum(IncludeToken::Always),
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($secureConversationToken),
        );
    }
}
