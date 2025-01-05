<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractNestedPolicyType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\EndorsingSupportingTokens;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\EndorsingSupportingTokensTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(EndorsingSupportingTokens::class)]
#[CoversClass(AbstractNestedPolicyType::class)]
#[CoversClass(AbstractSpElement::class)]
final class EndorsingSupportingTokensTest extends TestCase
{
    use NestedPolicyTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $some */
    protected static Chunk $some;

    /** @var \SimpleSAML\XML\Chunk $other */
    protected static Chunk $other;

    /** @var \SimpleSAML\XML\Attribute $attr */
    protected static XMLAttribute $attr;

    /** @var \SimpleSAML\WSSecurity\XML\wsp\Policy $policy */
    protected static Policy $policy;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = EndorsingSupportingTokens::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/EndorsingSupportingTokens.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        self::$some = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        self::$other = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Other</ssp:Chunk>',
        )->documentElement);

        $Id = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', 'MyId');
        self::$policy = new Policy('phpunit', $Id, [new ExactlyOne()], [self::$other], [self::$attr]);
    }
}
