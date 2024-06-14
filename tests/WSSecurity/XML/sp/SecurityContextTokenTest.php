<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp\AbstractTokenAssertionType;
use SimpleSAML\WSSecurity\XML\sp\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp\IncludeTokenTypeTrait;
use SimpleSAML\WSSecurity\XML\sp\SecurityContextToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\SecurityContextTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(SecurityContextToken::class)]
#[CoversClass(IncludeTokenTypeTrait::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SecurityContextTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = SecurityContextToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_SecurityContextToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty SecurityContextToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $securityContextToken = new SecurityContextToken();
        $this->assertEquals(
            "<sp:SecurityContextToken xmlns:sp=\"$spns\"/>",
            strval($securityContextToken),
        );
        $this->assertTrue($securityContextToken->isEmptyElement());
    }


    /**
     * Test that creating a SecurityContextToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $securityContextToken = new SecurityContextToken(IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($securityContextToken),
        );
    }
}
