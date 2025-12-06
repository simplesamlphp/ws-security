<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Type\MustUnderstandValue;
use SimpleSAML\WSSecurity\XML\wsa_200508\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractOnBehalfOfType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\OnBehalfOf;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\OnBehalfOfTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(OnBehalfOf::class)]
#[CoversClass(AbstractOnBehalfOfType::class)]
#[CoversClass(AbstractWstElement::class)]
final class OnBehalfOfTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = OnBehalfOf::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/OnBehalfOf.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a OnBehalfOf object from scratch.
     */
    public function testMarshalling(): void
    {
        $mustUnderstand = MustUnderstandValue::fromBoolean(true);
        $msgId = new MessageID(
            AnyURIValue::fromString('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de'),
            [$mustUnderstand->toAttribute()],
        );

        $onBehalfOf = new OnBehalfOf($msgId);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($onBehalfOf),
        );
    }
}
