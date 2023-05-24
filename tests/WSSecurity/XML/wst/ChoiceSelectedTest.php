<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wst\ChoiceSelected;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:ChoiceSelected.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class ChoiceSelectedTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ChoiceSelected::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_ChoiceSelected.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ChoiceSelected object from scratch.
     */
    public function testMarshalling(): void
    {
        $choiceSelected = new ChoiceSelected('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceSelected)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ChoiceSelected from XML.
     */
    public function testUnmarshalling(): void
    {
        $choiceSelected = ChoiceSelected::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceSelected)
        );
    }
}
