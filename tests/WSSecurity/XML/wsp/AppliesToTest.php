<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\Address;
use SimpleSAML\WSSecurity\XML\wsa_200508\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement;
use SimpleSAML\WSSecurity\XML\wsp\AppliesTo;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\AppliesToTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsp')]
#[CoversClass(AppliesTo::class)]
#[CoversClass(AbstractWspElement::class)]
final class AppliesToTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = AppliesTo::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy-200409.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_AppliesTo.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'value1');

        $AppliesTo = new AppliesTo(
            [new EndpointReference(new Address('http://www.fabrikam123.example.com/acct'))],
            [$domAttr],
        );
        $this->assertFalse($AppliesTo->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($AppliesTo),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $AppliesTo = new AppliesTo([], []);
        $this->assertEquals(
            '<wsp:AppliesTo xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy"/>',
            strval($AppliesTo),
        );
        $this->assertTrue($AppliesTo->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $AppliesTo = AppliesTo::fromXML(self::$xmlRepresentation->documentElement);

        $elements = $AppliesTo->getElements();
        $this->assertFalse($AppliesTo->isEmptyElement());
        $this->assertCount(1, $elements);

        $attributes = $AppliesTo->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = array_pop($attributes);
        $this->assertEquals(
            [
                'namespaceURI' => 'urn:x-simplesamlphp:namespace',
                'namespacePrefix' => 'ssp',
                'attrName' => 'attr1',
                'attrValue' => 'value1',
            ],
            $attribute->toArray(),
        );
    }
}
