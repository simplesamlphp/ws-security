<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\AbstractReferenceTokenType;
use SimpleSAML\WSSecurity\XML\fed\ReferenceDigest;
use SimpleSAML\WSSecurity\XML\fed\ReferenceEPR;
use SimpleSAML\WSSecurity\XML\fed\ReferenceToken;
use SimpleSAML\WSSecurity\XML\fed\ReferenceType;
use SimpleSAML\WSSecurity\XML\fed\SerialNo;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\Address;
use SimpleSAML\WSSecurity\XML\wsa_200508\Metadata;
use SimpleSAML\WSSecurity\XML\wsa_200508\ReferenceParameters;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:ReferenceToken.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(ReferenceToken::class)]
#[CoversClass(AbstractReferenceTokenType::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ReferenceTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;

    /** @var \DOMElement $metadataContent */
    protected static DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;

    /** @var \DOMElement $someChunk */
    protected static DOMElement $someChunk;

    /** @var \DOMElement $some */
    protected static DOMElement $some;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceToken.xml',
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        )->documentElement;

        self::$some = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an ReferenceToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $doc = DOMDocumentFactory::fromString('<root/>');

        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', 'testval3');
        $attr4 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr4', 'testval4');
        $attr5 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr5', 'testval5');
        $attr6 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr6', 'testval6');
        $attr7 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr7', 'testval7');
        $attr8 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr8', 'testval8');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$attr4]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr5]);
        $chunk = new Chunk(self::$customContent);
        $some = new Chunk(self::$some);

        $referenceEPR = new ReferenceEPR(
            new Address('https://login.microsoftonline.com/login.srf', [$attr3]),
            $referenceParameters,
            $metadata,
            [$chunk],
            [$attr2],
        );

        $referenceDigest = new ReferenceDigest('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=', [$attr6]);
        $referenceType = new ReferenceType(C::NAMESPACE, [$attr7]);
        $serialNo = new SerialNo(C::NAMESPACE, [$attr8]);

        $referenceToken = new ReferenceToken(
            [$referenceEPR],
            $referenceDigest,
            $referenceType,
            $serialNo,
            [$some],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceToken),
        );
    }
}
