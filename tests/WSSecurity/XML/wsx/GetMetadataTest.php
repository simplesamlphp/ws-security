<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsx;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsx\Dialect;
use SimpleSAML\WSSecurity\XML\wsx\GetMetadata;
use SimpleSAML\WSSecurity\XML\wsx\Identifier;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsx:GetMetadata.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsx\GetMetadata
 * @covers \SimpleSAML\WSSecurity\XML\wsx\AbstractWsxElement
 * @package tvdijen/ws-security
 */
final class GetMetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = GetMetadata::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/MetadataExchange.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsx_GetMetadata.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an GetMetadata object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $getMetadata = new GetMetadata(
            new Dialect('urn:x-simplesamlphp:namespace'),
            new Identifier('urn:x-simplesamlphp:namespace'),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($getMetadata)
        );
    }
}
