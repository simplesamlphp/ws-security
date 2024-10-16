<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200508\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractParticipantsType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\Participant;
use SimpleSAML\WSSecurity\XML\wst_200512\Participants;
use SimpleSAML\WSSecurity\XML\wst_200512\Primary;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\ParticipantsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Participants::class)]
#[CoversClass(AbstractParticipantsType::class)]
#[CoversClass(AbstractWstElement::class)]
final class ParticipantsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200512.xsd';

        self::$testedClass = Participants::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/Participants.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Participants object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $primary = new Primary($msgId);
        $participant = new Participant($msgId);
        $participants = new Participants($primary, [$participant], [$msgId]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($participants),
        );
    }


    /**
     * Adding an empty Participants element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $wstns = C::NS_TRUST_200512;
        $participants = new Participants();
        $this->assertEquals(
            "<trust:Participants xmlns:trust=\"$wstns\"/>",
            strval($participants),
        );
        $this->assertTrue($participants->isEmptyElement());
    }
}
