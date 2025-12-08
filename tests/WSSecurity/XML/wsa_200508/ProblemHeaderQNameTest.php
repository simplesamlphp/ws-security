<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa_200508;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractAttributedQNameType;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractWsaElement;
use SimpleSAML\WSSecurity\XML\wsa_200508\ProblemHeaderQName;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsa')]
#[CoversClass(ProblemHeaderQName::class)]
#[CoversClass(AbstractAttributedQNameType::class)]
#[CoversClass(AbstractWsaElement::class)]
final class ProblemHeaderQNameTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ProblemHeaderQName::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa/200508/ProblemHeaderQName.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemHeaderQName object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('value1'));

        $problemHeaderQName = new ProblemHeaderQName(
            QNameValue::fromParts(
                NCNameValue::fromString('Action'),
                AnyURIValue::fromString(AbstractWsaElement::NS),
                NCNameValue::fromString('wsa10'),
            ),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($problemHeaderQName),
        );
    }
}
