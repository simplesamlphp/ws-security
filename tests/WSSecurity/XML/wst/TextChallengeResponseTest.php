<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst\TextChallengeResponse;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:TextChallengeResponse.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\TextChallengeResponse
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class TextChallengeResponseTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = TextChallengeResponse::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_TextChallengeResponse.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an TextChallengeResponse object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'test', 'attr1', 'testval1');

        $textChallengeResponse = new TextChallengeResponse('654321', C::WST_REFID_PIN, [$domAttr]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($textChallengeResponse)
        );
    }


    // test unmarshalling


    /**
     * Test creating a TextChallengeResponse from XML.
     */
    public function testUnmarshalling(): void
    {
        $textChallengeResponse = TextChallengeResponse::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($textChallengeResponse)
        );
    }
}
