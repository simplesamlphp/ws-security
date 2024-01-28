<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\Description;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for auth:Description.
 *
 * @covers \SimpleSAML\WSSecurity\XML\auth\Description
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractDescriptionType
 * @covers \SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement
 * @package simplesamlphp/ws-security
 */
final class DescriptionTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Description::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_Description.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an Description object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $description = new Description('MyDescription', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($description)
        );
    }
}
