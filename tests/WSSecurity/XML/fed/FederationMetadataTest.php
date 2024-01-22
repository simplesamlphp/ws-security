<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\Federation;
use SimpleSAML\WSSecurity\XML\fed\FederationMetadata;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:FederationMetadata.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\FederationMetadata
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFederationMetadataType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
final class FederationMetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = FederationMetadata::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_FederationMetadata.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Federation object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $federation = new Federation('urn:some:uri', [new Chunk($child->documentElement)], [$attr2]);
        $federationMetadata = new FederationMetadata([$federation], [new Chunk($child->documentElement)], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federationMetadata),
        );
    }
}
