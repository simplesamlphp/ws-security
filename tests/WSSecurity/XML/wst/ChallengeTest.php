<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wst\Challenge;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\ChallengeTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\Challenge
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package simplesamlphp/ws-security
 */
final class ChallengeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = Challenge::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_Challenge.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Challenge object from scratch.
     */
    public function testMarshalling(): void
    {
        $challenge = new Challenge('accepted');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($challenge),
        );
    }
}
