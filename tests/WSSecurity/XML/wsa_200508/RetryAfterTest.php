<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractAttributedLongType;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\RetryAfter;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:RetryAfter.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(RetryAfter::class)]
#[CoversClass(AbstractAttributedLongType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class RetryAfterTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RetryAfter::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr-200508.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/RetryAfter.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an RetryAfter object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', 'value');
        $retryAfter = new RetryAfter('1234567890', [$attr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($retryAfter),
        );
    }
}
