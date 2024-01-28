<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\SecurityTokenReference;
use SimpleSAML\WSSecurity\XML\wst\RequestedUnattachedReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\RequestedUnattachedReferenceTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\RequestedUnattachedReference
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractRequestedReferenceType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package simplesamlphp/ws-security
 */
final class RequestedUnattachedReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = RequestedUnattachedReference::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_RequestedUnattachedReference.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestedUnattachedReference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $securityTokenReference = new SecurityTokenReference(
            'SomeID',
            'SomeUsage',
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $requestedUnattachedReference = new RequestedUnattachedReference($securityTokenReference);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestedUnattachedReference),
        );
    }
}
