<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\RequestedTokenCancelled;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\RequestedTokenCancelledTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\RequestedTokenCancelled
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class RequestedTokenCancelledTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = RequestedTokenCancelled::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_RequestedTokenCancelled.xml',
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
