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
use SimpleSAML\XML\Attribute;
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
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = InteractiveChallengeResponse::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_InteractiveChallengeResponse.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an InteractiveChallengeResponse object from scratch.
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

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

        $this->assertCount(1, $interactiveChallengeResponse->getTextChallengeResponse());
        $this->assertCount(1, $interactiveChallengeResponse->getChoiceChallengeResponse());
        $this->assertCount(1, $interactiveChallengeResponse->getContextData());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($interactiveChallengeResponse)
        );
    }


    /**
     * Adding an empty InteractiveChallengeResponse element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $wstns = C::NS_TRUST;
        $interactiveChallengeResponse = new InteractiveChallengeResponse();
        $this->assertEquals(
            "<wst:InteractiveChallengeResponse xmlns:wst=\"$wstns\"/>",
            strval($interactiveChallengeResponse),
        );
        $this->assertTrue($interactiveChallengeResponse->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test creating a TextChallengeResponse from XML.
     */
    public function testUnmarshalling(): void
    {
        $interactiveChallengeResponse = InteractiveChallengeResponse::fromXML(
            self::$xmlRepresentation->documentElement
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($interactiveChallengeResponse)
        );
    }
}
