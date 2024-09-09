<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200408;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractAttributedQNameType;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200408\PortType;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:PortType.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(PortType::class)]
#[CoversClass(AbstractAttributedQNameType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class PortTypeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PortType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/PortType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an PortType object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', 'value');
        $portType = new PortType('ssp:Chunk', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($portType),
        );
    }
}
