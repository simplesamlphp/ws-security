<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\RequireClientEntropy;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\RequireClientEntropyTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\sp\RequireClientEntropy
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class RequireClientEntropyTest extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = RequireClientEntropy::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_RequireClientEntropy.xml',
        );
    }
}
