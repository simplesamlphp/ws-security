<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp\AbstractIssuedTokenType;
use SimpleSAML\WSSecurity\XML\sp\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp\IncludeTokenTypeTrait;
use SimpleSAML\WSSecurity\XML\sp\IssuedToken;
use SimpleSAML\WSSecurity\XML\sp\IssuerName;
use SimpleSAML\WSSecurity\XML\sp\RequestSecurityTokenTemplate;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\IssuedTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(IssuedToken::class)]
#[CoversClass(IncludeTokenTypeTrait::class)]
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
            dirname(__FILE__, 4) . '/resources/xml/sp_IssuedToken.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);
        $requestSecurityTokenTemplate = new RequestSecurityTokenTemplate(
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );

        $issuedToken = new IssuedToken($requestSecurityTokenTemplate, $issuer, IncludeToken::Always, [$chunk], [$attr]);
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
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');
        $requestSecurityTokenTemplate = new RequestSecurityTokenTemplate(
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );

        $issuedToken = new IssuedToken($requestSecurityTokenTemplate, $issuer, IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuedToken),
        );
    }
}
