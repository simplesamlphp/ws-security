<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\AbstractSecurityTokenReferenceType;
use SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement;
use SimpleSAML\WSSecurity\XML\wsse\SecurityTokenReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:SecurityTokenReference.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsse')]
#[CoversClass(SecurityTokenReference::class)]
#[CoversClass(AbstractSecurityTokenReferenceType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class SecurityTokenReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SecurityTokenReference::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_SecurityTokenReference.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SecurityTokenReference object from scratch.
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

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($securityTokenReference),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $securityTokenReference = new SecurityTokenReference();

        $this->assertTrue($securityTokenReference->isEmptyElement());
    }
}
