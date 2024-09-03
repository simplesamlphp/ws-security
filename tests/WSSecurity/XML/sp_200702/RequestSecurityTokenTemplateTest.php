<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractRequestSecurityTokenTemplateType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\RequestSecurityTokenTemplate;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\RequestSecurityTokenTemplateTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(RequestSecurityTokenTemplate::class)]
#[CoversClass(AbstractRequestSecurityTokenTemplateType::class)]
#[CoversClass(AbstractSpElement::class)]
final class RequestSecurityTokenTemplateTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequestSecurityTokenTemplate::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/RequestSecurityTokenTemplate.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating a RequestSecurityTokenTemplate from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $RequestSecurityTokenTemplateElements = new RequestSecurityTokenTemplate(
            'urn:x-simplesamlphp:version',
            [$chunk],
            [$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($RequestSecurityTokenTemplateElements),
        );
    }


    /**
     * Adding an empty RequestSecurityTokenTemplate element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_12;
        $RequestSecurityTokenTemplate = new RequestSecurityTokenTemplate();
        $this->assertEquals(
            "<sp:RequestSecurityTokenTemplate xmlns:sp=\"$spns\"/>",
            strval($RequestSecurityTokenTemplate),
        );
        $this->assertTrue($RequestSecurityTokenTemplate->isEmptyElement());
    }
}
