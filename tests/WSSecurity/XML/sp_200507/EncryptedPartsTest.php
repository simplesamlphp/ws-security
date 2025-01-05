<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSePartsType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\Body;
use SimpleSAML\WSSecurity\XML\sp_200507\EncryptedParts;
use SimpleSAML\WSSecurity\XML\sp_200507\Header;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\EncryptedPartsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(EncryptedParts::class)]
#[CoversClass(AbstractSePartsType::class)]
#[CoversClass(AbstractSpElement::class)]
final class EncryptedPartsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = EncryptedParts::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/EncryptedParts.xml',
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
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $EncryptedParts = new EncryptedParts($body, [$header], [$chunk], [$attr]);

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
        $spns = C::NS_SEC_POLICY_11;
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
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $EncryptedParts = new EncryptedParts($body, [$header], [$chunk], [$attr]);
        $EncryptedPartsElement = $EncryptedParts->toXML();

        // Test for a Body
        $xpCache = XPath::getXPath($EncryptedPartsElement);
        $EncryptedPartsElements = XPath::xpQuery($EncryptedPartsElement, './sp:Body', $xpCache);
        $this->assertCount(1, $EncryptedPartsElements);

        // Test ordering of EncryptedParts contents
        /** @psalm-var \DOMElement[] $EncryptedPartsElements */
        $EncryptedPartsElements = XPath::xpQuery($EncryptedPartsElement, './sp:Body/following-sibling::*', $xpCache);
        $this->assertCount(2, $EncryptedPartsElements);
        $this->assertEquals('sp:Header', $EncryptedPartsElements[0]->tagName);
        $this->assertEquals('ssp:Chunk', $EncryptedPartsElements[1]->tagName);
    }
}
