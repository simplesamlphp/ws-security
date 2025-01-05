<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractReqPartsType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\Header;
use SimpleSAML\WSSecurity\XML\sp_200702\RequiredParts;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\RequiredPartsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(RequiredParts::class)]
#[CoversClass(AbstractReqPartsType::class)]
#[CoversClass(AbstractSpElement::class)]
final class RequiredPartsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequiredParts::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/RequiredParts.xml',
        );
    }


    /**
     * Adding an empty RequiredParts element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_12;
        $requiredParts = new RequiredParts([]);
        $this->assertEquals(
            "<sp:RequiredParts xmlns:sp=\"$spns\"/>",
            strval($requiredParts),
        );
        $this->assertTrue($requiredParts->isEmptyElement());
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $header = new Header('urn:x-simplesamlphp:namespace', 'ssp:name', [$attr]);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $RequiredParts = new RequiredParts([$header], [$chunk], [$attr]);
        $RequiredPartsElement = $RequiredParts->toXML();

        // Test for a Header
        $xpCache = XPath::getXPath($RequiredPartsElement);
        $RequiredPartsElements = XPath::xpQuery($RequiredPartsElement, './sp:Header', $xpCache);
        $this->assertCount(1, $RequiredPartsElements);

        // Test ordering of RequiredParts contents
        /** @psalm-var \DOMElement[] $RequiredPartsElements */
        $RequiredPartsElements = XPath::xpQuery($RequiredPartsElement, './sp:Header/following-sibling::*', $xpCache);
        $this->assertCount(1, $RequiredPartsElements);
        $this->assertEquals('ssp:Chunk', $RequiredPartsElements[0]->tagName);
    }


    // test marshalling


    /**
     * Test that creating a RequiredParts from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $header = new Header('urn:x-simplesamlphp:namespace', 'ssp:name', [$attr]);
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $RequiredParts = new RequiredParts([$header], [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($RequiredParts),
        );
    }
}
