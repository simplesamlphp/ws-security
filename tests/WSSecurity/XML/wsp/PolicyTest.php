<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsp\AbstractOperatorContentType;
use SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\PolicyTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsp')]
#[CoversClass(Policy::class)]
#[CoversClass(AbstractOperatorContentType::class)]
#[CoversClass(AbstractWspElement::class)]
final class PolicyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Policy::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy-200409.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_Policy.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an Policy from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $Id = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', 'MyId');
        $policy = new Policy('phpunit', $Id, [new ExactlyOne([])], [$chunk], [$attr]);

        $this->assertFalse($policy->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($policy),
        );
    }


    /**
     * Test that creating an empty Policy from scratch works.
     */
    public function testMarshallingEmpty(): void
    {
        $policy = new Policy();
        $this->assertTrue($policy->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating an empty Policy from XML succeeds.
     */
    public function testUnmarshallingEmptyElement(): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromString(
            '<wsp:Policy xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy" />',
        );

        $policy = Policy::fromXML($xmlRepresentation->documentElement);
        $this->assertTrue($policy->isEmptyElement());
    }
}
