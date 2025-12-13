<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractProblemActionType;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\Action;
use SimpleSAML\WSSecurity\XML\wsa_200508\ProblemAction;
use SimpleSAML\WSSecurity\XML\wsa_200508\SoapAction;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(ProblemAction::class)]
#[CoversClass(AbstractProblemActionType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ProblemActionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ProblemAction::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/ProblemAction.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemAction object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'test', StringValue::fromString('value'));

        $problemAction = new ProblemAction(
            new Action(AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'), [$attr1]),
            new SoapAction(AnyURIValue::fromString('http://www.example.com/')),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($problemAction),
        );
    }


    /**
     * Adding an empty ProblemAction element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $wsans = C::NS_ADDR_200508;
        $problemAction = new ProblemAction();
        $this->assertEquals(
            "<wsa10:ProblemAction xmlns:wsa10=\"$wsans\"/>",
            strval($problemAction),
        );
        $this->assertTrue($problemAction->isEmptyElement());
    }
}
