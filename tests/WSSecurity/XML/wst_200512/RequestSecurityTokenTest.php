<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200508\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractRequestSecurityTokenType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(RequestSecurityToken::class)]
#[CoversClass(AbstractRequestSecurityTokenType::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestSecurityTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequestSecurityToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/RequestSecurityToken.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestSecurityToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $RequestSecurityToken = new RequestSecurityToken(C::NAMESPACE, [$msgId], [$attr2]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($RequestSecurityToken),
        );
    }


    /**
     * Test creating an empty RequestSecurityToken object from scratch.
     */
    public function testMarshallingEmpty(): void
    {
        $RequestSecurityToken = new RequestSecurityToken();

        $this->assertTrue($RequestSecurityToken->isEmptyElement());
    }
}
