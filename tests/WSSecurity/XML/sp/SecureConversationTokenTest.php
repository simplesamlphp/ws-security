<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp\IssuerName;
use SimpleSAML\WSSecurity\XML\sp\SecureConversationToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\SecureConversationTokenTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\SecureConversationToken
 * @covers \SimpleSAML\WSSecurity\XML\sp\IncludeTokenTypeTrait
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSecureConversationTokenType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package simplesamlphp/ws-security
 */
final class SecureConversationTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = SecureConversationToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_SecureConversationToken.xml',
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

        $secureConversationToken = new SecureConversationToken($issuer, IncludeToken::Always, [$chunk], [$attr]);
        $secureConversationTokenElement = $secureConversationToken->toXML();

        // Test for a IssuerName
        $xpCache = XPath::getXPath($secureConversationTokenElement);
        $secureConversationTokenElements = XPath::xpQuery($secureConversationTokenElement, './sp:IssuerName', $xpCache);
        $this->assertCount(1, $secureConversationTokenElements);

        // Test ordering of SecureConversationToken contents
        /** @psalm-var \DOMElement[] $secureConversationTokenElements */
        $secureConversationTokenElements = XPath::xpQuery(
            $secureConversationTokenElement,
            './sp:IssuerName/following-sibling::*',
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
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $issuer = new IssuerName('urn:x-simplesamlphp:issuer');

        $secureConversationToken = new SecureConversationToken($issuer, IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($secureConversationToken),
        );
    }
}
