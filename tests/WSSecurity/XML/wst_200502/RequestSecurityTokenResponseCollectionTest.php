<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Type\MustUnderstandValue;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200408\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractRequestSecurityTokenResponseCollectionType;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\RequestSecurityTokenResponse;
use SimpleSAML\WSSecurity\XML\wst_200502\RequestSecurityTokenResponseCollection;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200502\RequestSecurityTokenResponseCollectionTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(RequestSecurityTokenResponseCollection::class)]
#[CoversClass(AbstractRequestSecurityTokenResponseCollectionType::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestSecurityTokenResponseCollectionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = RequestSecurityTokenResponseCollection::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/RequestSecurityTokenResponseCollection.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestSecurityTokenResponseCollection object from scratch.
     */
    public function testMarshalling(): void
    {
        $mustUnderstand = MustUnderstandValue::fromBoolean(true);
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$mustUnderstand->toAttribute()]);

        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $requestSecurityTokenResponse = new RequestSecurityTokenResponse(C::NAMESPACE, [$msgId], [$attr1]);

        $requestSecurityTokenResponseCollection = new RequestSecurityTokenResponseCollection(
            [$requestSecurityTokenResponse],
            [$attr2],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestSecurityTokenResponseCollection),
        );
    }
}
