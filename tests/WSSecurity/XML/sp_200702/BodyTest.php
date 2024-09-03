<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractEmptyType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\Body;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\BodyTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(Body::class)]
#[CoversClass(AbstractEmptyType::class)]
#[CoversClass(AbstractSpElement::class)]
final class BodyTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Body::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/Body.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating a Body from scratch works.
     */
    public function testMarshalling(): void
    {
        $body = new Body();

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body),
        );
    }
}
