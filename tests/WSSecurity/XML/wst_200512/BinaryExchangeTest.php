<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractBinaryExchangeType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\BinaryExchange;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\BinaryExchangeTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(BinaryExchange::class)]
#[CoversClass(AbstractBinaryExchangeType::class)]
#[CoversClass(AbstractWstElement::class)]
final class BinaryExchangeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = BinaryExchange::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/BinaryExchange.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a BinaryExchange object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $binaryExchange = new BinaryExchange(
            StringValue::fromString('phpunit'),
            AnyURIValue::fromString(C::NAMESPACE),
            AnyURIValue::fromString(C::NAMESPACE),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binaryExchange),
        );
    }
}
