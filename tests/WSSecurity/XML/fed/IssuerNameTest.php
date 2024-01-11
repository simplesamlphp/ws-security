<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\IssuerName;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:IssuerName.
 *
 * @covers \SimpleSAML\WSSecurity\XML\fed\IssuerName
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractIssuerNameType
 * @covers \SimpleSAML\WSSecurity\XML\fed\AbstractFedElement
 * @package tvdijen/ws-security
 */
final class IssuerNameTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = IssuerName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_IssuerName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a IssuerName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $issuerName = new IssuerName(
            'urn:some:uri',
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuerName),
        );
    }
}
