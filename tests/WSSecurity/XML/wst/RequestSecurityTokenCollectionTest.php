<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\WSSecurity\XML\wst\AbstractRequestSecurityTokenCollectionType;
use SimpleSAML\WSSecurity\XML\wst\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst\RequestSecurityToken;
use SimpleSAML\WSSecurity\XML\wst\RequestSecurityTokenCollection;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\RequestSecurityTokenCollectionTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(RequestSecurityTokenCollection::class)]
#[CoversClass(AbstractRequestSecurityTokenCollectionType::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestSecurityTokenCollectionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = RequestSecurityTokenCollection::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_RequestSecurityTokenCollection.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestSecurityTokenCollection object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $msgId1 = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);
        $msgId2 = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7df', [$attr1]);

        $requestSecurityToken1 = new RequestSecurityToken(C::NAMESPACE, [$msgId1], [$attr2]);
        $requestSecurityToken2 = new RequestSecurityToken(C::NAMESPACE, [$msgId2], [$attr3]);

        $requestSecurityTokenCollection = new RequestSecurityTokenCollection([
            $requestSecurityToken1,
            $requestSecurityToken2,
        ]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestSecurityTokenCollection),
        );
    }
}
