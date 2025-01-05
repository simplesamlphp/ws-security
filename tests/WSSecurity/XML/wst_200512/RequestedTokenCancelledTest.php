<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\RequestedTokenCancelled;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\RequestedTokenCancelledTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(RequestedTokenCancelled::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestedTokenCancelledTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequestedTokenCancelled::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/RequestedTokenCancelled.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestedTokenCancelled object from scratch.
     */
    public function testMarshalling(): void
    {
        $requestedTokenCancelled = new RequestedTokenCancelled();

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestedTokenCancelled),
        );
    }


    /**
     * Test creating an empty RequestedTokenCancelled object from scratch.
     *
     * NOTE: This element is empty per definition!
     */
    public function testMarshallingEmpty(): void
    {
        $requestedTokenCancelled = new RequestedTokenCancelled();
        $this->assertFalse($requestedTokenCancelled->isEmptyElement());
    }
}
