<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\DateTimeValue;
use SimpleSAML\WebServices\Security\XML\wsu\Created;
use SimpleSAML\WebServices\Security\XML\wsu\Expires;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractLifetimeType;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\Lifetime;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\LifetimeTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Lifetime::class)]
#[CoversClass(AbstractLifetimeType::class)]
#[CoversClass(AbstractWstElement::class)]
final class LifetimeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = Lifetime::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/Lifetime.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Lifetime object from scratch.
     */
    public function testMarshalling(): void
    {
        $created = new Created(DateTimeValue::fromString('2001-09-13T08:42:00Z'));
        $expires = new Expires(DateTimeValue::fromString('2001-10-13T09:00:00Z'));
        $lifetime = new Lifetime($created, $expires);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($lifetime),
        );
    }


    /**
     * Test creating an empty Lifetime object from scratch.
     */
    public function testMarshallingEmpty(): void
    {
        $lifetime = new Lifetime();

        $this->assertTrue($lifetime->isEmptyElement());
    }
}
