<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\ClaimDialect;
use SimpleSAML\WSSecurity\XML\fed\ClaimDialectsOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:ClaimDialectsOffered.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\ClaimDialectsOffered
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractClaimDialectsOfferedType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class ClaimDialectsOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimDialectsOffered::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ClaimDialectsOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ClaimDialectsOffered object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $child1 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $claimDialect = new ClaimDialect(
            'urn:some:uri',
            [new Chunk($child1->documentElement)],
            [$attr2],
        );

        $claimDialectsOffered = new ClaimDialectsOffered(
            [$claimDialect],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimDialectsOffered),
        );
    }
}
