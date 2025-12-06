<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement;
use SimpleSAML\WSSecurity\XML\wsx\Location;
use SimpleSAML\WSSecurity\XML\wsx\MetadataSection;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsx:MetadataSection.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsx')]
#[CoversClass(MetadataSection::class)]
#[CoversClass(AbstractWsxElement::class)]
final class MetadataSectionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = MetadataSection::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_MetadataSection.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an MetadataSection object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));

        $metadataSection = new MetadataSection(
            new Location(AnyURIValue::fromString('urn:x-simplesamlphp:namespace')),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($metadataSection),
        );
    }
}
