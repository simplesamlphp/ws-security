<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType;
use SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:MessageID.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(MessageID::class)]
#[CoversClass(AbstractAttributedURIType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class MessageIDTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = MessageID::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_MessageID.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an MessageID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute(C::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($msgId),
        );
    }
}
