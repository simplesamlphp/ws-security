<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpnegoContextTokenType;
use SimpleSAML\WSSecurity\XML\sp_200702\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200702\IssuerName;
use SimpleSAML\WSSecurity\XML\sp_200702\SpnegoContextToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\SpnegoContextTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(SpnegoContextToken::class)]
#[CoversClass(AbstractSpnegoContextTokenType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SpnegoContextTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = SpnegoContextToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/SpnegoContextToken.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $includeToken = new XMLAttribute(C::NS_SEC_POLICY_12, 'sp', 'IncludeToken', IncludeToken::Always->value);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $spnegoContextToken = new SpnegoContextToken($issuer, [$chunk], [$includeToken, $attr]);
        $spnegoContextTokenElement = $spnegoContextToken->toXML();

        // Test for a IssuerName
        $xpCache = XPath::getXPath($spnegoContextTokenElement);
        $spnegoContextTokenElements = XPath::xpQuery($spnegoContextTokenElement, './sp:IssuerName', $xpCache);
        $this->assertCount(1, $spnegoContextTokenElements);

        // Test ordering of SpnegoContextToken contents
        /** @psalm-var \DOMElement[] $spnegoContextTokenElements */
        $spnegoContextTokenElements = XPath::xpQuery(
            $spnegoContextTokenElement,
            './sp:IssuerName/following-sibling::*',
            $xpCache,
        );
        $this->assertCount(1, $spnegoContextTokenElements);
        $this->assertEquals('ssp:Chunk', $spnegoContextTokenElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a SpnegoContextToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $includeToken = new XMLAttribute(C::NS_SEC_POLICY_12, 'sp', 'IncludeToken', IncludeToken::Always->value);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');

        $spnegoContextToken = new SpnegoContextToken($issuer, [$chunk], [$includeToken, $attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($spnegoContextToken),
        );
    }
}
