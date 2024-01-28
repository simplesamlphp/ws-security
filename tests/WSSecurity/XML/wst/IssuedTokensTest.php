<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\WSSecurity\XML\wst\IssuedTokens;
use SimpleSAML\WSSecurity\XML\wst\RequestSecurityTokenResponse;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\IssuedTokensTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\IssuedTokens
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 *
 * @package simplesamlphp/ws-security
 */
final class IssuedTokensTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = IssuedTokens::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_IssuedTokens.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a IssuedTokens object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $requestSecurityTokenResponse = new RequestSecurityTokenResponse(C::NAMESPACE, [$msgId], [$attr2]);

        $issuedTokens = new IssuedTokens(
            [$requestSecurityTokenResponse],
            [$attr3],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuedTokens),
        );
    }
}
