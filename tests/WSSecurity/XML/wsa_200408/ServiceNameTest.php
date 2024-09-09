<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200408;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractServiceNameType;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200408\ServiceName;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:ServiceName.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(ServiceName::class)]
#[CoversClass(AbstractServiceNameType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ServiceNameTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ServiceName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/ServiceName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an ServiceName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', 'value');
        $serviceName = new ServiceName('ssp:Chunk', 'PHPUnit', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($serviceName),
        );
    }
}
