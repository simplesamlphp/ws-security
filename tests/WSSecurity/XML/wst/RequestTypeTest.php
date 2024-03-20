<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\AbstractRequestTypeOpenEnum;
use SimpleSAML\WSSecurity\XML\wst\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst\RequestType;
use SimpleSAML\WSSecurity\XML\wst\RequestTypeEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\RequestTypeTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(RequestType::class)]
#[CoversClass(AbstractRequestTypeOpenEnum::class)]
#[CoversClass(AbstractWstElement::class)]
final class RequestTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = RequestType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_RequestType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestType object from scratch.
     */
    public function testMarshalling(): void
    {
        $requestType = new RequestType([RequestTypeEnum::Issue]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestType),
        );
    }
}
