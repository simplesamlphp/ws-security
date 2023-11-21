<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\XML\wsp\All;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingAttributeException;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\AllTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsp\All
 * @covers \SimpleSAML\WSSecurity\XML\wsp\AbstractOperatorContentType
 * @covers \SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement
 * @package tvdijen/ws-security
 */
final class AllTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = All::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_All.xml'
        );
    }


    // test marshalling


    /**
     * Test that creating an All from scratch works.
     */
    public function testMarshalling(): void
    {
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $all = new All([new ExactlyOne([])], [$chunk]);

        $this->assertFalse($all->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($all),
        );
    }


    /**
     * Test that creating an empty All from scratch works.
     */
    public function testMarshallingEmpty(): void
    {
        $oc = new All();
        $this->assertTrue($oc->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating an empty All from XML succeeds.
     */
    public function testUnmarshallingEmptyElement(): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromString(
            '<wsp:All xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy" />',
        );

        $oc = All::fromXML($xmlRepresentation->documentElement);
        $this->assertTrue($oc->isEmptyElement());
    }
}
