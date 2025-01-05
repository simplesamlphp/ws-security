<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractAttributedURIType;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\To;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:To.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(To::class)]
#[CoversClass(AbstractAttributedURIType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ToTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = To::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/To.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an To object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr', 'test');

        $to = new To('https://login.microsoftonline.com/login.srf', [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($to),
        );
    }
}
