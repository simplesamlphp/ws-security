<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractFederationMetadataHandlerType;
use SimpleSAML\WSSecurity\XML\fed\FederationMetadataHandler;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\FederationMetadataHandlerTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(FederationMetadataHandler::class)]
#[CoversClass(AbstractFederationMetadataHandlerType::class)]
#[CoversClass(AbstractFedElement::class)]
final class FederationMetadataHandlerTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-federation.xsd';

        self::$testedClass = FederationMetadataHandler::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_FederationMetadataHandler.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a FederationMetadataHandler object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $federationMetadataHandler = new FederationMetadataHandler([$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federationMetadataHandler),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $federationMetadataHandler = new FederationMetadataHandler();
        $this->assertTrue($federationMetadataHandler->isEmptyElement());
    }
}
