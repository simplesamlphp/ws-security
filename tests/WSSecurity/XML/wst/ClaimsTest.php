<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\WSSecurity\XML\wst\AbstractClaimsType;
use SimpleSAML\WSSecurity\XML\wst\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst\Claims;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\ClaimsTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(Claims::class)]
#[CoversClass(AbstractClaimsType::class)]
#[CoversClass(AbstractWstElement::class)]
final class ClaimsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = Claims::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Claims.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Claims object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr2]);

        $claims = new Claims(C::NAMESPACE, [$msgId], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claims),
        );
    }


    /**
     * Test creating an empty Claims object from scratch.
     */
    public function testMarshallingEmpty(): void
    {
        $claims = new Claims();

        $this->assertTrue($claims->isEmptyElement());
    }
}
