<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\AbstractReferenceType;
use SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement;
use SimpleSAML\WSSecurity\XML\wsse\Reference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:Reference.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsse')]
#[CoversClass(Reference::class)]
#[CoversClass(AbstractReferenceType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class ReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Reference::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_Reference.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Reference object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));

        $reference = new Reference(
            AnyURIValue::fromString('urn:some:uri'),
            AnyURIValue::fromString('http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken'),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($reference),
        );
    }
}
