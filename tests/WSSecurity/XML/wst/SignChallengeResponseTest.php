<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\WSSecurity\XML\wst\Challenge;
use SimpleSAML\WSSecurity\XML\wst\SignChallengeResponse;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\SignChallengeResponseTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\SignChallengeResponse
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractSignChallengeType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class SignChallengeResponseTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = SignChallengeResponse::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_SignChallengeResponse.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SignChallengeResponse object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $challenge = new Challenge('accepted');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');

        $signChallengeResponse = new SignChallengeResponse($challenge, [$msgId], [$attr2]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signChallengeResponse),
        );
    }
}
