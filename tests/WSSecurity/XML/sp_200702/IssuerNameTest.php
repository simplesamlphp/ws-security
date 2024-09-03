<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\IssuerName;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for IssuerName.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(IssuerName::class)]
#[CoversClass(AbstractSpElement::class)]
final class IssuerNameTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = IssuerName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/IssuerName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a IssuerName object from scratch.
     */
    public function testMarshalling(): void
    {
        $issuerName = new IssuerName('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuerName),
        );
    }
}
