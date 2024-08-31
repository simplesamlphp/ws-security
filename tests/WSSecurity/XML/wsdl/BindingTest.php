<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractBinding;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsdl\Binding;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperation;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationFault;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationInput;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationOutput;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Binding.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsdl')]
#[CoversClass(Binding::class)]
#[CoversClass(AbstractBinding::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BindingTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Binding::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl_Binding.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Binding object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $operationChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OperationChunk</ssp:Chunk>',
        );
        $inputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">InputChunk</ssp:Chunk>',
        );
        $outputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OutputChunk</ssp:Chunk>',
        );
        $faultOneChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultOneChunk</ssp:Chunk>',
        );
        $faultTwoChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultTwoChunk</ssp:Chunk>',
        );

        $input = new BindingOperationInput('CustomInputName', [new Chunk($inputChild->documentElement)]);
        $output = new BindingOperationOutput('CustomOutputName', [new Chunk($outputChild->documentElement)]);
        $faultOne = new BindingOperationFault('CustomFaultOne', [new Chunk($faultOneChild->documentElement)]);
        $faultTwo = new BindingOperationFault('CustomFaultTwo', [new Chunk($faultTwoChild->documentElement)]);

        $operationOne = new BindingOperation(
            'OperationOne',
            $input,
            $output,
            [$faultOne, $faultTwo],
            [new Chunk($operationChild->documentElement)],
        );
        $operationTwo = new BindingOperation('OperationTwo');

        $binding = new Binding(
            'MyBinding',
            'ssp:CustomType',
            [$operationOne, $operationTwo],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binding),
        );
    }
}
