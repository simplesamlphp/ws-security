<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\IssuesSpecificPolicyFault;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\IssuesSpecificPolicyFaultTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\IssuesSpecificPolicyFault
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractAssertionType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 *
 * @package tvdijen/ws-security
 */
final class IssuesSpecificPolicyFaultTest extends TestCase
{
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

        self::$testedClass = IssuesSpecificPolicyFault::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_IssuesSpecificPolicyFault.xml',
        );

        self::$attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>'
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating a RequireSignedTokens object from scratch.
     */
    public function testMarshalling(): void
    {
        $issuesSpecificPolicyFault = new IssuesSpecificPolicyFault(
            [self::$chunk],
            [self::$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuesSpecificPolicyFault),
        );
    }
}
