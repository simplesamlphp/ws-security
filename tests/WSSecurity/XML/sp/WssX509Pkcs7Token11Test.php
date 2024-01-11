<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\WssX509Pkcs7Token11;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\WssX509Pkcs7Token11Test
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\WssX509Pkcs7Token11
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class WssX509Pkcs7Token11Test extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = WssX509Pkcs7Token11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_WssX509Pkcs7Token11.xml',
        );
    }
}
