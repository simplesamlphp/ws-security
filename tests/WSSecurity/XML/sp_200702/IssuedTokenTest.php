<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractIssuedTokenType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200702\IssuedToken;
use SimpleSAML\WSSecurity\XML\sp_200702\IssuerName;
use SimpleSAML\WSSecurity\XML\sp_200702\RequestSecurityTokenTemplate;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\IssuedTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(IssuedToken::class)]
#[CoversClass(AbstractIssuedTokenType::class)]
#[CoversClass(AbstractSpElement::class)]
final class IssuedTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = IssuedToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/IssuedToken.xml',
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
        $requestSecurityTokenTemplate = new RequestSecurityTokenTemplate(
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );

        $issuedToken = new IssuedToken($requestSecurityTokenTemplate, $issuer, [$chunk], [$includeToken, $attr]);
        $issuedTokenElement = $issuedToken->toXML();

        // Test for a Issuer
        $xpCache = XPath::getXPath($issuedTokenElement);
        $issuedTokenElements = XPath::xpQuery($issuedTokenElement, './sp:IssuerName', $xpCache);
        $this->assertCount(1, $issuedTokenElements);

        // Test ordering of IssuedToken contents
        /** @psalm-var \DOMElement[] $issuedTokenElements */
        $issuedTokenElements = XPath::xpQuery($issuedTokenElement, './sp:IssuerName/following-sibling::*', $xpCache);
        $this->assertCount(2, $issuedTokenElements);
        $this->assertEquals('sp:RequestSecurityTokenTemplate', $issuedTokenElements[0]->tagName);
        $this->assertEquals('ssp:Chunk', $issuedTokenElements[1]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a IssuedToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $includeToken = new XMLAttribute(C::NS_SEC_POLICY_12, 'sp', 'IncludeToken', IncludeToken::Always->value);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');
        $requestSecurityTokenTemplate = new RequestSecurityTokenTemplate(
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );

        $issuedToken = new IssuedToken($requestSecurityTokenTemplate, $issuer, [$chunk], [$includeToken, $attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuedToken),
        );
    }
}
