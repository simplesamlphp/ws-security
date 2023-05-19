<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst\Image;
use SimpleSAML\WSSecurity\XML\wst\TextChallenge;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:TextChallenge.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\TextChallenge
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class TextChallengeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = TextChallenge::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_TextChallenge.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an TextChallenge object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $image = new Image(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=',
            'image/png',
        );
        $textChallenge = new TextChallenge('#_abc123', 'SomeLabel', 10, true, $image, [$domAttr]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($textChallenge)
        );
    }


    // test unmarshalling


    /**
     * Test creating a TextChallenge from XML.
     */
    public function testUnmarshalling(): void
    {
        $textChallenge = TextChallenge::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($textChallenge)
        );
    }
}
