<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp\WssGssKerberosV5ApReqToken11;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp\WssGssKerberosV5ApReqToken11Test
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(WssGssKerberosV5ApReqToken11::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class WssGssKerberosV5ApReqToken11Test extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = WssGssKerberosV5ApReqToken11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp_WssGssKerberosV5ApReqToken11.xml',
        );
    }
}
