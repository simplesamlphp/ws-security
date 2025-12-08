<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSecureConversationTokenType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200702\IssuerName;
use SimpleSAML\WSSecurity\XML\sp_200702\SecureConversationToken;
use SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\SecureConversationTokenTest
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


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SecureConversationToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/SecureConversationToken.xml',
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $issuer = new IssuerName(AnyURIValue::fromString('urn:x-simplesamlphp:issuer'));
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $includeToken = IncludeTokenValue::fromEnum(IncludeToken::Always);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $secureConversationToken = new SecureConversationToken(
            $issuer,
            [$chunk],
            [$includeToken->toAttribute(), $attr],
        );
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
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $includeToken = IncludeTokenValue::fromEnum(IncludeToken::Always);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $issuer = new IssuerName(AnyURIValue::fromString('urn:x-simplesamlphp:issuer'));

        $secureConversationToken = new SecureConversationToken(
            $issuer,
            [$chunk],
            [$includeToken->toAttribute(), $attr],
        );
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($secureConversationToken),
        );
    }
}
