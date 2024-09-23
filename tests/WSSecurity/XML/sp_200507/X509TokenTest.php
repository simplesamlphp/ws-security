<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractTokenAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200507\X509Token;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\X509TokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(X509Token::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class X509TokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.1.xsd';

        self::$testedClass = X509Token::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/X509Token.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty X509Token element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_11;
        $X509Token = new X509Token();
        $this->assertEquals(
            "<sp:X509Token xmlns:sp=\"$spns\"/>",
            strval($X509Token),
        );
        $this->assertTrue($X509Token->isEmptyElement());
    }


    /**
     * Test that creating a X509Token from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $includeToken = new XMLAttribute(C::NS_SEC_POLICY_11, 'sp', 'IncludeToken', IncludeToken::Always->value);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $X509Token = new X509Token([$chunk], [$includeToken, $attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($X509Token),
        );
    }
}
