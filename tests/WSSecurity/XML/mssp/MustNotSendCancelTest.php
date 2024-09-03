<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\mssp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\XML\sp_200507\QNameAssertionTypeTestTrait;
use SimpleSAML\WSSecurity\XML\mssp\MustNotSendCancel;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\mssp\MustNotSendCancelTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(MustNotSendCancel::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class MustNotSendCancelTest extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/mssp.xsd';

        self::$testedClass = MustNotSendCancel::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/mssp_MustNotSendCancel.xml',
        );
    }
}
