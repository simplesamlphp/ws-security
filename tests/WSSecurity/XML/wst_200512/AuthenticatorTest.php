<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Type\MustUnderstandValue;
use SimpleSAML\WSSecurity\XML\wsa_200508\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractAuthenticatorType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\Authenticator;
use SimpleSAML\WSSecurity\XML\wst_200512\CombinedHash;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\AuthenticatorTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Authenticator::class)]
#[CoversClass(AbstractAuthenticatorType::class)]
#[CoversClass(AbstractWstElement::class)]
final class AuthenticatorTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Authenticator::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/Authenticator.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Authenticator object from scratch.
     */
    public function testMarshalling(): void
    {
        $mustUnderstand = MustUnderstandValue::fromBoolean(true);
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$mustUnderstand->toAttribute()]);

        $combinedHash = new CombinedHash('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=');
        $authenticator = new Authenticator($combinedHash, [$msgId]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($authenticator),
        );
    }


    /**
     * Test creating an empty Authenticator object from scratch.
     */
    public function testMarshallingEmpty(): void
    {
        $authenticator = new Authenticator();

        $this->assertTrue($authenticator->isEmptyElement());
    }
}
