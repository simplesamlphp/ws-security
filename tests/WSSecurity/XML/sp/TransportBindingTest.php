<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\TransportBinding;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\TransportBindingTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\TransportBinding
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractNestedPolicyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class TransportBindingTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = TransportBinding::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_TransportBinding.xml',
        );
    }


    /**
     * Adding an empty TransportBinding element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY;
        $TransportBinding = new TransportBinding();
        $this->assertEquals(
            "<sp:TransportBinding xmlns:sp=\"$spns\"/>",
            strval($TransportBinding),
        );
        $this->assertTrue($TransportBinding->isEmptyElement());
    }


    // test marshalling


    /**
     * Test that creating a TransportBinding from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);

        $TransportBinding = new TransportBinding([$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($TransportBinding),
        );
    }


    // test unmarshalling


    /**
     * Test that creating a TransportBinding from XML succeeds.
     */
    public function testUnmarshalling(): void
    {
        $TransportBinding = TransportBinding::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($TransportBinding),
        );
    }
}
