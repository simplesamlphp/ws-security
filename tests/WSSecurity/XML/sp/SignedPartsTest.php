<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp\Attachments;
use SimpleSAML\WSSecurity\XML\sp\Body;
use SimpleSAML\WSSecurity\XML\sp\Header;
use SimpleSAML\WSSecurity\XML\sp\SignedParts;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\SignedPartsTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\SignedParts
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSePartsType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class SignedPartsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = SignedParts::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_SignedParts.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty SignedParts element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $signedParts = new SignedParts();
        $this->assertEquals(
            "<sp:SignedParts xmlns:sp=\"$spns\"/>",
            strval($signedParts),
        );
        $this->assertTrue($signedParts->isEmptyElement());
    }


    /**
     * Test that creating a SignedParts from scratch works.
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

        $signedParts = new SignedParts($body, [$header], $attachments, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signedParts),
        );
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

        $SignedParts = new SignedParts($body, [$header], $attachments, [$chunk], [$attr]);
        $SignedPartsElement = $SignedParts->toXML();

        // Test for a Body
        $xpCache = XPath::getXPath($SignedPartsElement);
        $SignedPartsElements = XPath::xpQuery($SignedPartsElement, './sp:Body', $xpCache);
        $this->assertCount(1, $SignedPartsElements);

        // Test ordering of SignedParts contents
        /** @psalm-var \DOMElement[] $SignedPartsElements */
        $SignedPartsElements = XPath::xpQuery($SignedPartsElement, './sp:Body/following-sibling::*', $xpCache);
        $this->assertCount(3, $SignedPartsElements);
        $this->assertEquals('sp:Header', $SignedPartsElements[0]->tagName);
        $this->assertEquals('sp:Attachments', $SignedPartsElements[1]->tagName);
        $this->assertEquals('ssp:Chunk', $SignedPartsElements[2]->tagName);
    }
}
