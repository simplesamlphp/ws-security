<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\AbstractAttributedString;
use SimpleSAML\WSSecurity\XML\wsse\AbstractBinarySecurityTokenType;
use SimpleSAML\WSSecurity\XML\wsse\AbstractEncodedString;
use SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement;
use SimpleSAML\WSSecurity\XML\wsse\BinarySecurityToken;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:BinarySecurityToken.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsse')]
#[CoversClass(BinarySecurityToken::class)]
#[CoversClass(AbstractBinarySecurityTokenType::class)]
#[CoversClass(AbstractEncodedString::class)]
#[CoversClass(AbstractAttributedString::class)]
#[CoversClass(AbstractWsseElement::class)]
final class BinarySecurityTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = BinarySecurityToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_BinarySecurityToken.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a BinarySecurityToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));

        $binarySecurityToken = new BinarySecurityToken(
            StringValue::fromString($content),
            IDValue::fromString('SomeID'),
            [$attr1],
            AnyURIValue::fromString('http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken'),
            AnyURIValue::fromString('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd#base64binary'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binarySecurityToken),
        );
    }
}
