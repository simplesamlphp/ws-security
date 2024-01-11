<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:Address.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\Address
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractAttributedURIType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class AddressTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Address::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_Address.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an Address object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', 'value');
        $address = new Address('https://login.microsoftonline.com/login.srf', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($address)
        );
    }
}
