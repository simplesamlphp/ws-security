<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst\SignWith;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\SignWithTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\SignWith
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class SignWithTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = SignWith::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_SignWith.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SignWith object from scratch.
     */
    public function testMarshalling(): void
    {
        $signWith = new SignWith(C::NAMESPACE);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signWith),
        );
    }
}
