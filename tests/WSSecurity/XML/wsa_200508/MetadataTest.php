<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\Metadata;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsa\MetadataTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(Metadata::class)]
#[CoversClass(AbstractWsaElement::class)]
final class MetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $MetadataContent */
    private static DOMElement $metadataContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Metadata::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/Metadata.xml',
        );

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'value1');

        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$domAttr]);
        $this->assertFalse($metadata->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($metadata),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $metadata = new Metadata([], []);
        $this->assertEquals(
            '<wsa10:Metadata xmlns:wsa10="http://www.w3.org/2005/08/addressing"/>',
            strval($metadata),
        );
        $this->assertTrue($metadata->isEmptyElement());
    }
}
