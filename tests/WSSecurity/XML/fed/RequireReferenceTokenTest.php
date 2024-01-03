<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Utils\XPath;
use SimpleSAML\WSSecurity\XML\sp\IncludeToken;
use SimpleSAML\WSSecurity\XML\fed\RequireReferenceToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\RequireReferenceTokenTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\RequireReferenceToken
 * @covers \SimpleSAML\WSSecurity\XML\sp\IncludeTokenTypeTrait
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractTokenAssertionType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class RequireReferenceTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = RequireReferenceToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_RequireReferenceToken.xml',
        );
    }


    // test marshalling


    /**
     * Adding an empty X509lToken element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $fedns = C::NS_FED;
        $requireReferenceToken = new RequireReferenceToken();
        $this->assertEquals(
            "<fed:RequireReferenceToken xmlns:fed=\"$fedns\"/>",
            strval($requireReferenceToken),
        );
        $this->assertTrue($requireReferenceToken->isEmptyElement());
    }


    /**
     * Test that creating a RequireReferenceToken from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">some</ssp:Chunk>'
        )->documentElement);

        $requireReferenceToken = new RequireReferenceToken(IncludeToken::Always, [$chunk], [$attr]);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requireReferenceToken),
        );
    }
}
