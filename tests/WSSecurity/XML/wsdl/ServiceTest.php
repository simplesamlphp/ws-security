<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsdl\Port;
use SimpleSAML\WSSecurity\XML\wsdl\Service;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Service.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsdl')]
#[CoversClass(Service::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class ServiceTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Service::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl_Service.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Service object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $chunkOne = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">ChunkOne</ssp:Chunk>',
        );
        $chunkTwo = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">ChunkTwo</ssp:Chunk>',
        );

        $portOne = new Port('PortOne', 'ssp:CustomBinding', [new Chunk($chunkOne->documentElement)]);
        $portTwo = new Port('PortTwo', 'ssp:CustomBinding', [new Chunk($chunkTwo->documentElement)]);

        $service = new Service('MyService', [$portOne, $portTwo], [new Chunk($child->documentElement)]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($service),
        );
    }
}
