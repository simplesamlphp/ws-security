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
use SimpleSAML\WSSecurity\XML\sp\SamlToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\SamlTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(SamlToken::class)]
#[CoversClass(IncludeTokenTypeTrait::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SamlTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = SamlToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_SamlToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty SamlToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $samlToken = new SamlToken();
        $this->assertEquals(
            "<sp:SamlToken xmlns:sp=\"$spns\"/>",
            strval($samlToken),
        );
        $this->assertTrue($samlToken->isEmptyElement());
    }


    /**
     * Test that creating a SamlToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $samlToken = new SamlToken(IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($samlToken),
        );
    }
}
