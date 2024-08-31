<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp\WssSamlV11Token11;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\WssSamlV11Token11Test
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(WssSamlV11Token11::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class WssSamlV11Token11Test extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = WssSamlV11Token11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_WssSamlV11Token11.xml',
        );
    }
}
