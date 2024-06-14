<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\ReferenceEPR;
use SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\Metadata;
use SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:ReferenceEPR.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(ReferenceEPR::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ReferenceEPRTest extends TestCase
{
    use SerializableElementTestTrait;


    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;

    /** @var \DOMElement $metadataContent */
    protected static DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceEPR::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceEPR.xml',
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
    }


    // test marshalling


    /**
     * Test creating an ReferenceEPR object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'testval3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'testval4');

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$attr3]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr4]);
        $chunk = new Chunk(self::$customContent);

        $referenceEPR = new ReferenceEPR(
            new Address('https://login.microsoftonline.com/login.srf', [$attr2]),
            [$referenceParameters],
            [$metadata],
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceEPR),
        );
    }
}
