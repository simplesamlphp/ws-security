<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractPortType;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsdl\Fault;
use SimpleSAML\WSSecurity\XML\wsdl\Input;
use SimpleSAML\WSSecurity\XML\wsdl\Output;
use SimpleSAML\WSSecurity\XML\wsdl\PortType;
use SimpleSAML\WSSecurity\XML\wsdl\PortTypeOperation as Operation;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Operation.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsdl')]
#[CoversClass(PortType::class)]
#[CoversClass(AbstractPortType::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class PortTypeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PortType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl_PortType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an PortType object from scratch.
     */
    public function testMarshalling(): void
    {
        $port = new XMLAttribute(C::NAMESPACE, 'ssp', 'port', '1234');
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'value2');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', 'value3');

        $input = new Input('ssp:CustomInputMessage', 'CustomInputName', [$attr1]);
        $output = new Output('ssp:CustomOutputMessage', 'CustomOutputName', [$attr2]);
        $fault = new Fault('CustomFaultName', 'ssp:CustomFaultMessage', [$attr3]);

        $inputOperation = new Operation('Input', '0836217462 0836217463', $input, $output, [$fault]);
        $outputOperation = new Operation('Output', '0836217462 0836217463', $output, $input, [$fault]);

        $portType = new PortType('MyPort', [$inputOperation, $outputOperation], [$port]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($portType),
        );
    }
}
