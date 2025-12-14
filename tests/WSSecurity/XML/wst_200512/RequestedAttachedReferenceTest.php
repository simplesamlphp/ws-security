<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractRequestedReferenceType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\RequestedAttachedReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\RequestedAttachedReferenceTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(RequestedAttachedReference::class)]
#[CoversClass(AbstractRequestedReferenceType::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestedAttachedReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequestedAttachedReference::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/RequestedAttachedReference.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestedAttachedReference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $securityTokenReference = new SecurityTokenReference(
            IDValue::fromString('SomeID'),
            AnyURIValue::fromString('SomeUsage'),
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $requestedAttachedReference = new RequestedAttachedReference($securityTokenReference);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestedAttachedReference),
        );
    }
}
