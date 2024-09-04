<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
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
 * Class \SimpleSAML\WSSecurity\XML\wsp\AllTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsp')]
#[CoversClass(All::class)]
#[CoversClass(AbstractOperatorContentType::class)]
#[CoversClass(AbstractWspElement::class)]
final class AllTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = All::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy-200409.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_All.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an All from scratch works.
     */
    public function testMarshalling(): void
    {
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
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
