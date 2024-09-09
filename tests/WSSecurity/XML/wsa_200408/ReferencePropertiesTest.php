<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200408;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceProperties;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsa\ReferencePropertiesTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(ReferenceProperties::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ReferencePropertiesTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \DOMElement $ReferencePropertiesContent */
    private static DOMElement $ReferencePropertiesContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceProperties::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/ReferenceProperties.xml',
        );

        self::$ReferencePropertiesContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $ReferenceProperties = new ReferenceProperties([new Chunk(self::$ReferencePropertiesContent)]);
        $this->assertFalse($ReferenceProperties->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($ReferenceProperties),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $ReferenceProperties = new ReferenceProperties([]);
        $this->assertEquals(
            '<wsa:ReferenceProperties xmlns:wsa="http://schemas.xmlsoap.org/ws/2004/08/addressing"/>',
            strval($ReferenceProperties),
        );
        $this->assertTrue($ReferenceProperties->isEmptyElement());
    }
}
