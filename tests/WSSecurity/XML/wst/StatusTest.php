<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\Code;
use SimpleSAML\WSSecurity\XML\wst\Reason;
use SimpleSAML\WSSecurity\XML\wst\Status;
use SimpleSAML\WSSecurity\XML\wst\StatusCodeEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\StatusTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\Status
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractStatusType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class StatusTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = Status::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Status.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Status object from scratch.
     */
    public function testMarshalling(): void
    {
        $code = new Code(StatusCodeEnum::Invalid);
        $reason = new Reason('phpunit');
        $status = new Status($code, $reason);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($status),
        );
    }
}
