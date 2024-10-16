<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200408\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractSignChallengeType;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\Challenge;
use SimpleSAML\WSSecurity\XML\wst_200502\SignChallengeResponse;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200502\SignChallengeResponseTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(SignChallengeResponse::class)]
#[CoversClass(AbstractSignChallengeType::class)]
#[CoversClass(AbstractWstElement::class)]
final class SignChallengeResponseTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = SignChallengeResponse::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/SignChallengeResponse.xml',
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
