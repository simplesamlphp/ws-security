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
use SimpleSAML\WSSecurity\XML\sp_200702\IncludeTokenTypeTrait;
use SimpleSAML\WSSecurity\XML\sp_200702\KerberosToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\KerberosTokenTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(KerberosToken::class)]
#[CoversClass(IncludeTokenTypeTrait::class)]
#[CoversClass(AbstractTokenAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class KerberosTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = KerberosToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/KerberosToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty KerberosToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $spns = C::NS_SEC_POLICY_12;
        $kerberosToken = new KerberosToken();
        $this->assertEquals(
            "<sp:KerberosToken xmlns:sp=\"$spns\"/>",
            strval($kerberosToken),
        );
        $this->assertTrue($kerberosToken->isEmptyElement());
    }


    /**
     * Test that creating a KerberosToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>',
        )->documentElement);

        $kerberosToken = new KerberosToken(IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($kerberosToken),
        );
    }
}
