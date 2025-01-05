<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\Test\WSSecurity\XML\sp_200702\NestedPolicyTypeTestTrait;
use SimpleSAML\WSSecurity\XML\fed\AuthenticationToken;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractNestedPolicyType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\AuthenticationTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(AuthenticationToken::class)]
#[CoversClass(AbstractNestedPolicyType::class)]
#[CoversClass(AbstractSpElement::class)]
final class AuthenticationTokenTest extends TestCase
{
    use NestedPolicyTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;

    /** @var \SimpleSAML\XML\Attribute $attr */
    protected static XMLAttribute $attr;

    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = AuthenticationToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_AuthenticationToken.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);
    }
}
