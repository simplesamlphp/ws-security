<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractStatusType;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\Code;
use SimpleSAML\WSSecurity\XML\wst_200502\Reason;
use SimpleSAML\WSSecurity\XML\wst_200502\Status;
use SimpleSAML\WSSecurity\XML\wst_200502\StatusCodeEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200502\StatusTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Status::class)]
#[CoversClass(AbstractStatusType::class)]
#[CoversClass(AbstractWstElement::class)]
final class StatusTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = Status::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/Status.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Status object from scratch.
     */
    public function testMarshalling(): void
    {
        $code = new Code([StatusCodeEnum::Invalid]);
        $reason = new Reason('phpunit');
        $status = new Status($code, $reason);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($status),
        );
    }
}
