<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement;
use SimpleSAML\WSSecurity\XML\wsx\Location;
use SimpleSAML\WSSecurity\XML\wsx\Metadata;
use SimpleSAML\WSSecurity\XML\wsx\MetadataSection;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsx:Metadata.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsx')]
#[CoversClass(Metadata::class)]
#[CoversClass(AbstractWsxElement::class)]
final class MetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Metadata::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_Metadata.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Metadata object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');

        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        );

        $metadataSection = new MetadataSection(
            new Location('urn:x-simplesamlphp:namespace'),
            'urn:x-simplesamlphp:namespace',
            'urn:x-simplesamlphp:namespace',
            [$attr2],
        );

        $metadata = new Metadata([$metadataSection], [new Chunk($child->documentElement)], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($metadata),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $metadata = new Metadata();

        $this->assertTrue($metadata->isEmptyElement());
    }
}
