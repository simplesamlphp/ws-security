<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsp\AbstractOperatorContentType;
use SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement;
use SimpleSAML\WSSecurity\XML\wsp\All;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\ExactlyOneTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(ExactlyOne::class)]
#[CoversClass(AbstractOperatorContentType::class)]
#[CoversClass(AbstractWspElement::class)]
final class ExactlyOneTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ExactlyOne::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_ExactlyOne.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an ExactlyOne from scratch works.
     */
    public function testMarshalling(): void
    {
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $exactlyOne = new ExactlyOne([new All()], [$chunk]);

        $this->assertFalse($exactlyOne->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($exactlyOne),
        );
    }


    /**
     * Test that creating an empty ExactlyOne from scratch works.
     */
    public function testMarshallingEmpty(): void
    {
        $oc = new ExactlyOne([]);
        $this->assertTrue($oc->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating an ExactlyOne from XML succeeds.
     */
    public function testUnmarshallingEmptyElement(): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromString(
            '<wsp:ExactlyOne xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy" />',
        );

        $oc = ExactlyOne::fromXML($xmlRepresentation->documentElement);
        $this->assertTrue($oc->isEmptyElement());
    }
}
