<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\AbstractStatusCodeOpenEnum;
use SimpleSAML\WSSecurity\XML\wst\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst\Code;
use SimpleSAML\WSSecurity\XML\wst\StatusCodeEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\CodeTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(Code::class)]
#[CoversClass(AbstractStatusCodeOpenEnum::class)]
#[CoversClass(AbstractWstElement::class)]
final class CodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Code::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Code.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Code object from scratch.
     */
    public function testMarshalling(): void
    {
        $code = new Code([StatusCodeEnum::Invalid]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($code),
        );
    }
}
