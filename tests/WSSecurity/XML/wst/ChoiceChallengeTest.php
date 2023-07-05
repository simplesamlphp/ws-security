<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\Choice;
use SimpleSAML\WSSecurity\XML\wst\ChoiceChallenge;
use SimpleSAML\WSSecurity\XML\wst\Image;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:ChoiceChallenge.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ChoiceChallenge
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class ChoiceChallengeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ChoiceChallenge::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_ChoiceChallenge.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ChoiceChallenge object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $domAttr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');

        $choice = new Choice(
            'urn:x-simplesamlphp:namespace', // RefID
            'SomeLabel', // Label
            $image = new Image(
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=',
                'image/png',
            ),
            [$domAttr1],
        );

        $choiceChallenge = new ChoiceChallenge(
            'urn:x-simplesamlphp:namespace', // RefID
            true,
            'OtherLabel',
            $choice,
            [$domAttr2],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceChallenge),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ChoiceChallenge from XML.
     */
    public function testUnmarshalling(): void
    {
        $choiceChallenge = ChoiceChallenge::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceChallenge),
        );
    }
}
