<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractFederationMetadataType;
use SimpleSAML\WSSecurity\XML\fed\Federation;
use SimpleSAML\WSSecurity\XML\fed\FederationMetadata;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:FederationMetadata.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(FederationMetadata::class)]
#[CoversClass(AbstractFederationMetadataType::class)]
#[CoversClass(AbstractFedElement::class)]
final class FederationMetadataTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
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
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $some = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        );
        $other = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Other</ssp:Chunk>',
        );

        $federation = new Federation(
            AnyURIValue::fromString('urn:some:uri'),
            [new Chunk($some->documentElement)],
            [$attr1],
        );

        $federationMetadata = new FederationMetadata(
            [$federation, new Chunk($other->documentElement)],
            [$attr2],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federationMetadata),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $federationMetadata = new FederationMetadata();
        $this->assertTrue($federationMetadata->isEmptyElement());
    }
}
