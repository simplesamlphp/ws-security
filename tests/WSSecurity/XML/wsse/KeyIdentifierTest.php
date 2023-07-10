<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsse\KeyIdentifier;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:KeyIdentifier.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsse\KeyIdentifier
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractKeyIdentifierType
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractEncodedString
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractAttributedString
 * @covers \SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement
 * @package tvdijen/ws-security
 */
final class KeyIdentifierTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = KeyIdentifier::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/oasis-200401-wss-wssecurity-secext-1.0.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_KeyIdentifier.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a KeyIdentifier object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $keyIdentifier = new KeyIdentifier(
            $content,
            'http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken',
            'SomeID',
            'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd#base64binary',
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($keyIdentifier),
        );
    }


    // test unmarshalling


    /**
     * Test creating a KeyIdentifier from XML.
     */
    public function testUnmarshalling(): void
    {
        $keyIdentifier = KeyIdentifier::fromXML(self::$xmlRepresentation->documentElement);
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($keyIdentifier),
        );
    }
}
