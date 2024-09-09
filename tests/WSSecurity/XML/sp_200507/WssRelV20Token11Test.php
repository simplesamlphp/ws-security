<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\WssRelV20Token11;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\WssRelV20Token11Test
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(WssRelV20Token11::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class WssRelV20Token11Test extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.1.xsd';

        self::$testedClass = WssRelV20Token11::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/WssRelV20Token11.xml',
        );
    }
}
