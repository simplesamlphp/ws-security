<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200408;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractAttributedURIType;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200408\RetryAfter;
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
#[CoversClass(AbstractAttributedURIType::class)]
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-addr-200408.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200408/RetryAfter.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an RetryAfter object from scratch.
     */
    public function testMarshalling(): void
    {
        $retryAfter = new RetryAfter(30);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($retryAfter),
        );
    }
}
