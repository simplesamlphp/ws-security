<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst\ChoiceChallengeResponse;
use SimpleSAML\WSSecurity\XML\wst\ChoiceSelected;
use SimpleSAML\WSSecurity\XML\wst\ContextData;
use SimpleSAML\WSSecurity\XML\wst\InteractiveChallengeResponse;
use SimpleSAML\WSSecurity\XML\wst\TextChallengeResponse;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:InteractiveChallengeResponse.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\InteractiveChallengeResponse
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class InteractiveChallengeResponseTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = InteractiveChallengeResponse::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_InteractiveChallengeResponse.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an InteractiveChallengeResponse object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'test:attr1');
        $domAttr->value = 'testval1';

        $textChallengeResponse = new TextChallengeResponse('654321', C::WST_REFID_PIN, [$domAttr]);
        $choiceChallengeResponse = new ChoiceChallengeResponse(
            'urn:x-simplesamlphp:namespace',
            [new ChoiceSelected('urn:x-simplesamlphp:namespace')],
        );
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);
        $contextData = new ContextData('urn:x-simplesamlphp:namespace', [$chunk]);
        $interactiveChallengeResponse = new InteractiveChallengeResponse(
            [$textChallengeResponse, $choiceChallengeResponse, $contextData, $chunk],
            [$domAttr],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($interactiveChallengeResponse)
        );
    }


    // test unmarshalling


    /**
     * Test creating a TextChallengeResponse from XML.
     */
    public function testUnmarshalling(): void
    {
        $interactiveChallengeResponse = InteractiveChallengeResponse::fromXML(
            $this->xmlRepresentation->documentElement
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($interactiveChallengeResponse)
        );
    }
}
