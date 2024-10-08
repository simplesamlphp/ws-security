<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\auth\AbstractAuthElement;
use SimpleSAML\WSSecurity\XML\auth\AbstractEncryptedValueType;
use SimpleSAML\WSSecurity\XML\auth\EncryptedValue;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSecurity\XML\ds\KeyInfo;
use SimpleSAML\XMLSecurity\XML\xenc\CipherData;
use SimpleSAML\XMLSecurity\XML\xenc\CipherValue;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedKey;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod;

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
            new CipherData(new CipherValue('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=')),
            'MyID',
            'http://www.w3.org/2001/04/xmlenc#Element',
            'text/plain',
            'urn:x-simplesamlphp:encoding',
            new EncryptionMethod('http://www.w3.org/2001/04/xmlenc#aes128-cbc'),
            new KeyInfo(
                [
                    new EncryptedKey(
                        new CipherData(new CipherValue('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=')),
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        new EncryptionMethod('http://www.w3.org/2001/04/xmldsig-more#rsa-sha256'),
                    ),
                ],
            ),
        );

        $encryptedValue = new EncryptedValue($encryptedData, 'urn:some:uri');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($encryptedValue),
        );
    }
}
