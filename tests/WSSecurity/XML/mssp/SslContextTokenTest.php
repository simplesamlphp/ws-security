<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\mssp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\mssp\SslContextToken;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractTokenAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\mssp\SslContextTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('mssp')]
#[CoversClass(SslContextToken::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SslContextTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SslContextToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/mssp/SslContextToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty SslContextToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $msspns = C::NS_MSSP;
        $sslContextToken = new SslContextToken();
        $this->assertEquals(
            "<mssp:SslContextToken xmlns:mssp=\"$msspns\"/>",
            strval($sslContextToken),
        );
        $this->assertTrue($sslContextToken->isEmptyElement());
    }


    /**
     * Test that creating a SslContextToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $includeToken = new XMLAttribute(C::NS_SEC_POLICY_12, 'sp', 'IncludeToken', IncludeToken::Always->value);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $sslContextToken = new SslContextToken([$chunk], [$includeToken, $attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($sslContextToken),
        );
    }
}
