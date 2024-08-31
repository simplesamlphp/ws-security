<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleString;
use SimpleSAML\WSSecurity\XML\fed\AbstractAttributeExtensibleURI;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\FederationID;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\FederationIDTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(FederationID::class)]
#[CoversClass(AbstractAttributeExtensibleURI::class)]
#[CoversClass(AbstractAttributeExtensibleString::class)]
#[CoversClass(AbstractFedElement::class)]
final class FederationIDTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = FederationID::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_FederationID.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a FederationID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $federationID = new FederationID(C::NAMESPACE, [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federationID),
        );
    }
}
