<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp\Lax;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\LaxTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(Lax::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class LaxTest extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = Lax::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_Lax.xml',
        );
    }
}
