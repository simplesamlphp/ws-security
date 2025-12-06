<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractComputedKeyOpenEnum;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\ComputedKey;
use SimpleSAML\WSSecurity\XML\wst_200502\ComputedKeyEnum;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200502\ComputedKeyTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(ComputedKey::class)]
#[CoversClass(AbstractComputedKeyOpenEnum::class)]
#[CoversClass(AbstractWstElement::class)]
final class ComputedKeyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = ComputedKey::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/ComputedKey.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ComputedKey object from scratch.
     */
    public function testMarshalling(): void
    {
        $computedKey = new ComputedKey(AnyURIValue::fromString(ComputedKeyEnum::PSHA1->value));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($computedKey),
        );
    }
}
