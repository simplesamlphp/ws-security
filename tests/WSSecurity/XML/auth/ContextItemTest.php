<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement;
use SimpleSAML\WSSecurity\XML\auth\AbstractContextItemType;
use SimpleSAML\WSSecurity\XML\auth\ContextItem;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:ContextItem.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(ContextItem::class)]
#[CoversClass(AbstractContextItemType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ContextItemTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ContextItem::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_ContextItem.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ContextItem object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        $contextItem = new ContextItem(
            C::NAMESPACE,
            'urn:x-simplesamlphp:scope',
            new Value('someValue'),
            null,
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($contextItem),
        );
    }
}
