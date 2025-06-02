<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\{AbstractAuthElement, AbstractEncryptedValueType, EncryptedValue};
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSecurity\XML\ds\KeyInfo;
use SimpleSAML\XMLSecurity\XML\xenc\{CipherData, CipherValue, EncryptedData, EncryptedKey, EncryptionMethod};
use SimpleSAML\XML\Type\{AnyURIValue, Base64BinaryValue, IDValue, StringValue};

use function dirname;
use function strval;

/**
 * Tests for auth:EncryptedValue.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('auth')]
#[CoversClass(EncryptedValue::class)]
#[CoversClass(AbstractEncryptedValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class EncryptedValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = EncryptedValue::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth_EncryptedValue.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an EncryptedValue object from scratch.
     */
    public function testMarshalling(): void
    {
        $encryptedData = new EncryptedData(
            new CipherData(
                new CipherValue(
                    Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
                ),
            ),
            IDValue::fromString('MyID'),
            AnyURIValue::fromString('http://www.w3.org/2001/04/xmlenc#Element'),
            StringValue::fromString('text/plain'),
            AnyURIValue::fromString('urn:x-simplesamlphp:encoding'),
            new EncryptionMethod(
                AnyURIValue::fromString('http://www.w3.org/2001/04/xmlenc#aes128-cbc'),
            ),
            new KeyInfo(
                [
                    new EncryptedKey(
                        new CipherData(
                            new CipherValue(
                                Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
                            ),
                        ),
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        new EncryptionMethod(
                            AnyURIValue::fromString('http://www.w3.org/2001/04/xmldsig-more#rsa-sha256'),
                        ),
                    ),
                ],
            ),
        );

        $encryptedValue = new EncryptedValue($encryptedData, AnyURIValue::fromString('urn:some:uri'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($encryptedValue),
        );
    }
}
