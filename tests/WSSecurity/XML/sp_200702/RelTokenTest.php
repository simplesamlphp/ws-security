<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractTokenAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200702\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200702\RelToken;
use SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\RelTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(RelToken::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class RelTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RelToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/RelToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty RelToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_12;
        $relToken = new RelToken();
        $this->assertEquals(
            "<sp:RelToken xmlns:sp=\"$spns\"/>",
            strval($relToken),
        );
        $this->assertTrue($relToken->isEmptyElement());
    }


    /**
     * Test that creating a RelToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $includeToken = IncludeTokenValue::fromEnum(IncludeToken::Always);
        $relToken = new RelToken([$chunk], [$includeToken->toAttribute(), $attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($relToken),
        );
    }
}
