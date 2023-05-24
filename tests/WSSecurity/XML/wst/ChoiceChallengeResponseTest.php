<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wst\ChoiceChallengeResponse;
use SimpleSAML\WSSecurity\XML\wst\ChoiceSelected;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wst:ChoiceChallengeResponse.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ChoiceChallengeResponse
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class ChoiceChallengeResponseTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ChoiceChallengeResponse::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_ChoiceChallengeResponse.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ChoiceChallengeResponse object from scratch.
     */
    public function testMarshalling(): void
    {
        $choiceChallengeResponse = new ChoiceChallengeResponse(
            'urn:x-simplesamlphp:namespace',
            [new ChoiceSelected('urn:x-simplesamlphp:namespace')],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceChallengeResponse)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ChoiceChallengeResponse from XML.
     */
    public function testUnmarshalling(): void
    {
        $choiceChallengeResponse = ChoiceChallengeResponse::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($choiceChallengeResponse)
        );
    }
}
