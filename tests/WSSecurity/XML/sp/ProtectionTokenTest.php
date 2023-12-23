<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\ProtectionToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\ProtectionTokenTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\ProtectionToken
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractNestedPolicyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class ProtectionTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = ProtectionToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_ProtectionToken.xml',
        );
    }


    /**
     * Adding an empty ProtectionToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $ProtectionToken = new ProtectionToken();
        $this->assertEquals(
            "<sp:ProtectionToken xmlns:sp=\"$spns\"/>",
            strval($ProtectionToken),
        );
        $this->assertTrue($ProtectionToken->isEmptyElement());
    }


    // test marshalling


    /**
     * Test that creating a ProtectionToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $ProtectionToken = new ProtectionToken([$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($ProtectionToken),
        );
    }


    // test unmarshalling


    /**
     * Test that creating a ProtectionToken from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $ProtectionToken = ProtectionToken::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($ProtectionToken),
        );
    }
}
