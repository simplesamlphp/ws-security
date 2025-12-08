<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\SoapAction;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(SoapAction::class)]
#[CoversClass(AbstractWsaElement::class)]
final class SoapActionTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SoapAction::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/SoapAction.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an SoapAction object from scratch.
     */
    public function testMarshalling(): void
    {
        $soapAction = new SoapAction(AnyURIValue::fromString('http://www.example.com/'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($soapAction),
        );
    }
}
