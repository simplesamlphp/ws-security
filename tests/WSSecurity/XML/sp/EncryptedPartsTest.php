<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp\Attachments;
use SimpleSAML\WSSecurity\XML\sp\Body;
use SimpleSAML\WSSecurity\XML\sp\EncryptedParts;
use SimpleSAML\WSSecurity\XML\sp\Header;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\EncryptedPartsTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\EncryptedParts
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSePartsType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package simplesamlphp/ws-security
 */
final class EncryptedPartsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = EncryptedParts::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_EncryptedParts.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating a EncryptedParts from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $body = new Body();
        $header = new Header('urn:x-simplesamlphp:namespace', 'ssp:name', [$attr]);
        $attachments = new Attachments();
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $EncryptedParts = new EncryptedParts($body, [$header], $attachments, [$chunk], [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($EncryptedParts),
        );
    }


    /**
     * Adding an empty EncryptedParts element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $encryptedParts = new EncryptedParts();
        $this->assertEquals(
            "<sp:EncryptedParts xmlns:sp=\"$spns\"/>",
            strval($encryptedParts),
        );
        $this->assertTrue($encryptedParts->isEmptyElement());
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $body = new Body();
        $header = new Header('urn:x-simplesamlphp:namespace', 'ssp:name', [$attr]);
        $attachments = new Attachments();
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $EncryptedParts = new EncryptedParts($body, [$header], $attachments, [$chunk], [$attr]);
        $EncryptedPartsElement = $EncryptedParts->toXML();

        // Test for a Body
        $xpCache = XPath::getXPath($EncryptedPartsElement);
        $EncryptedPartsElements = XPath::xpQuery($EncryptedPartsElement, './sp:Body', $xpCache);
        $this->assertCount(1, $EncryptedPartsElements);

        // Test ordering of EncryptedParts contents
        /** @psalm-var \DOMElement[] $EncryptedPartsElements */
        $EncryptedPartsElements = XPath::xpQuery($EncryptedPartsElement, './sp:Body/following-sibling::*', $xpCache);
        $this->assertCount(3, $EncryptedPartsElements);
        $this->assertEquals('sp:Header', $EncryptedPartsElements[0]->tagName);
        $this->assertEquals('sp:Attachments', $EncryptedPartsElements[1]->tagName);
        $this->assertEquals('ssp:Chunk', $EncryptedPartsElements[2]->tagName);
    }
}
