<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SchemaValidationTestTrait;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for wsa:MessageID.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\MessageID
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class MessageIDTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = MessageID::class;

        $this->schema = dirname(__FILE__, 5) . '/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_MessageID.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an MessageID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS(C::NS_SOAP_ENV, 'soapenv:mustUnderstand');
        $attr1->value = '1';

        $msgId = new MessageID('https://login.microsoftonline.com/login.srf', [$attr1]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($msgId)
        );
    }


    // test unmarshalling


    /**
     * Test creating a MessageID from XML.
     */
    public function testUnmarshalling(): void
    {
        $msgId = MessageID::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($msgId)
        );
    }
}
