<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\Test\WSSecurity\XML\sp\NestedPolicyTypeTestTrait;
use SimpleSAML\WSSecurity\XML\fed\WebBinding;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\WebBindingTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\WebBinding
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractNestedPolicyType
 * @covers \SimpleSAML\WSSecurity\XML\sp\AbstractSpElement
 *
 * @package tvdijen/ws-security
 */
final class WebBindingTest extends TestCase
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
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = WebBinding::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_WebBinding.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);
    }
}
