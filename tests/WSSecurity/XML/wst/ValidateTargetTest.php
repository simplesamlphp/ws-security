<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\WSSecurity\XML\wsa\MessageID;
use SimpleSAML\WSSecurity\XML\wst\ValidateTarget;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst\ValidateTargetTest
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ValidateTarget
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractValidateTargetType
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 *
 * @package tvdijen/ws-security
 */
final class ValidateTargetTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust.xsd';

        self::$testedClass = ValidateTarget::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst_ValidateTarget.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValidateTarget object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $validateTarget = new ValidateTarget($msgId);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($validateTarget),
        );
    }
}
