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
use SimpleSAML\WSSecurity\XML\sp_200507\Header;
use SimpleSAML\WSSecurity\XML\sp_200507\SignedParts;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\SignedPartsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(SignedParts::class)]
#[CoversClass(AbstractSePartsType::class)]
#[CoversClass(AbstractSpElement::class)]
final class SignedPartsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SignedParts::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/SignedParts.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty SignedParts element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_11;
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
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $signedParts = new SignedParts($body, [$header], [$chunk], [$attr]);
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
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $SignedParts = new SignedParts($body, [$header], [$chunk], [$attr]);
        $SignedPartsElement = $SignedParts->toXML();

        // Test for a Body
        $xpCache = XPath::getXPath($SignedPartsElement);
        $SignedPartsElements = XPath::xpQuery($SignedPartsElement, './sp:Body', $xpCache);
        $this->assertCount(1, $SignedPartsElements);

        // Test ordering of SignedParts contents
        /** @psalm-var \DOMElement[] $SignedPartsElements */
        $SignedPartsElements = XPath::xpQuery($SignedPartsElement, './sp:Body/following-sibling::*', $xpCache);
        $this->assertCount(2, $SignedPartsElements);
        $this->assertEquals('sp:Header', $SignedPartsElements[0]->tagName);
        $this->assertEquals('ssp:Chunk', $SignedPartsElements[1]->tagName);
    }
}
