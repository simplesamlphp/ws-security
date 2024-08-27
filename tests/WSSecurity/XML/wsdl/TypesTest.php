<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsdl\Types;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Types.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsdl')]
#[CoversClass(Types::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class TypesTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Types::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl_Types.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Types object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $types = new Types([new Chunk($child->documentElement)]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($types),
        );
    }
}
