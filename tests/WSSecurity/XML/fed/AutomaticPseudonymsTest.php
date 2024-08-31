<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AutomaticPseudonyms;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\AutomaticPseudonymsTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(AutomaticPseudonyms::class)]
#[CoversClass(AbstractFedElement::class)]
final class AutomaticPseudonymsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = AutomaticPseudonyms::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_AutomaticPseudonyms.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a AutomaticPseudonyms object from scratch.
     */
    public function testMarshalling(): void
    {
        $automaticPseudonyms = new AutomaticPseudonyms(true);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($automaticPseudonyms),
        );
    }
}
