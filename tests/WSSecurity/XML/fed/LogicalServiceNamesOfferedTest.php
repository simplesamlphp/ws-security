<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\IssuerName;
use SimpleSAML\WSSecurity\XML\fed\LogicalServiceNamesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:LogicalServiceNamesOffered.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\LogicalServiceNamesOffered
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractLogicalServiceNamesOfferedType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class LogicalServiceNamesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = LogicalServiceNamesOffered::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_LogicalServiceNamesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a LogicalServiceNamesOffered object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');

        $issuerName = new IssuerName(
            'urn:some:uri',
            [$attr2],
        );

        $logicalServiceNamesOffered = new LogicalServiceNamesOffered(
            [$issuerName],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($logicalServiceNamesOffered),
        );
    }
}
