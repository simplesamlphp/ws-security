<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wst\Choice;
use SimpleSAML\WSSecurity\XML\wst\Image;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:Choice.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\Choice
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class ChoiceTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Choice::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Choice.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an Choice object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $choice = new Choice(
            'urn:x-simplesamlphp:namespace', // RefID
            'SomeLabel', // Label
            $image = new Image(
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=',
                'image/png',
            ),
            [$domAttr],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($choice)
        );
    }


    // test unmarshalling


    /**
     * Test creating a Choice from XML.
     */
    public function testUnmarshalling(): void
    {
        $choice = Choice::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($choice)
        );
    }
}
