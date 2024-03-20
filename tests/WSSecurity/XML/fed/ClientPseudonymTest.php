<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractClientPseudonymType;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\ClientPseudonym;
use SimpleSAML\WSSecurity\XML\fed\DisplayName;
use SimpleSAML\WSSecurity\XML\fed\EMail;
use SimpleSAML\WSSecurity\XML\fed\PPID;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Utils\XPath;

use function dirname;
use function strval;

/**
 * Tests for fed:ClientPseudonym.
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(ClientPseudonym::class)]
#[CoversClass(AbstractClientPseudonymType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClientPseudonymTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = ClientPseudonym::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ClientPseudonym.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ClientPseudonym object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'testval3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'testval4');

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $clientPseudonym = new ClientPseudonym(
            new PPID('MyPPID', [$attr2]),
            new DisplayName('MyDisplayName', [$attr3]),
            new EMail('MyEMail', [$attr4]),
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($clientPseudonym)
        );
    }


    /**
     * Adding an empty ClientPseudonym element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $cp = new ClientPseudonym();
        $this->assertTrue($cp->isEmptyElement());
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'testval3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'testval4');

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $clientPseudonym = new ClientPseudonym(
            new PPID('MyPPID', [$attr2]),
            new DisplayName('MyDisplayName', [$attr3]),
            new EMail('MyEMail', [$attr4]),
            [$chunk],
            [$attr1],
        );
        $clientPseudonymElement = $clientPseudonym->toXML();

        // Test for a PPID
        $xpCache = XPath::getXPath($clientPseudonymElement);
        $clientPseudonymElements = XPath::xpQuery($clientPseudonymElement, './fed:PPID', $xpCache);
        $this->assertCount(1, $clientPseudonymElements);

        // Test ordering of ClientPseudonym contents
        /** @psalm-var \DOMElement[] $clientPseudonymElements */
        $clientPseudonymElements = XPath::xpQuery($clientPseudonymElement, './fed:PPID/following-sibling::*', $xpCache);
        $this->assertCount(3, $clientPseudonymElements);
        $this->assertEquals('fed:DisplayName', $clientPseudonymElements[0]->tagName);
        $this->assertEquals('fed:EMail', $clientPseudonymElements[1]->tagName);
        $this->assertEquals('ssp:Chunk', $clientPseudonymElements[2]->tagName);
    }
}
