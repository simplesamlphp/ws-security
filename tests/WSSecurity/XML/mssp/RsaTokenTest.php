<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\mssp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\mssp\RsaToken;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractTokenAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeTokenTypeTrait;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\mssp\RsaTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('mssp')]
#[CoversClass(RsaToken::class)]
#[CoversClass(IncludeTokenTypeTrait::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class RsaTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/mssp.xsd';

        self::$testedClass = RsaToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/mssp_RsaToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty RsaToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $msspns = C::NS_SEC_POLICY_11;
        $rsaToken = new RsaToken();
        $this->assertEquals(
            "<mssp:RsaToken xmlns:mssp=\"$msspns\"/>",
            strval($rsaToken),
        );
        $this->assertTrue($rsaToken->isEmptyElement());
    }


    /**
     * Test that creating a RsaToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $rsaToken = new RsaToken(IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($rsaToken),
        );
    }
}
