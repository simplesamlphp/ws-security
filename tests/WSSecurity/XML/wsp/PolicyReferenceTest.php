<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsp\PolicyReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\PolicyReferenceTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsp\PolicyReference
 * @covers \SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement
 * @package tvdijen/ws-security
 */
final class PolicyReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PolicyReference::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_PolicyReference.xml'
        );
    }


    // test marshalling


    /**
     * Test that creating an PolicyReference from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');

        $pr = new PolicyReference(
            'urn:x-simplesamlphp:phpunit',
            '/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=',
            'http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc',
            [$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($pr),
        );
    }
}
