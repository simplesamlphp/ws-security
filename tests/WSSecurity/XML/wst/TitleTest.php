<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wst\Title;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:Title.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\Title
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractTitleType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class TitleTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Title::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Title.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an Title object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:attr1');
        $attr1->value = 'value1';

        $title = new Title('phpunit', [$attr1]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($title)
        );
    }


    // test unmarshalling


    /**
     * Test creating a Title from XML.
     */
    public function testUnmarshalling(): void
    {
        $title = Title::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($title)
        );
    }
}
