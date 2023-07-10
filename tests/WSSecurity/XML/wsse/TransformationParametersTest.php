<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsse\TransformationParameters;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:TransformationParameters.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsse\TransformationParameters
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractTransformationParametersType
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement
 * @package tvdijen/ws-security
 */
final class TransformationParametersTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TransformationParameters::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/oasis-200401-wss-wssecurity-secext-1.0.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_TransformationParameters.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a TransformationParameters object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $transformationParameters = new TransformationParameters(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($transformationParameters),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $transformationParameters = new TransformationParameters();

        $this->assertTrue($transformationParameters->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test creating a TransformationParameters from XML.
     */
    public function testUnmarshalling(): void
    {
        $transformationParameters = TransformationParameters::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($transformationParameters),
        );
    }
}