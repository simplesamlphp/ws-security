<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement;
use SimpleSAML\WSSecurity\XML\wsp\AppliesTo;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\WSSecurity\XML\wsp\PolicyAttachment;
use SimpleSAML\WSSecurity\XML\wsp\PolicyReference;
use SimpleSAML\WSSecurity\XML\wsse\Security;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\PolicyAttachmentTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsp')]
#[CoversClass(PolicyAttachment::class)]
#[CoversClass(AbstractWspElement::class)]
final class PolicyAttachmentTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PolicyAttachment::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp_PolicyAttachment.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an PolicyAttachment from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr4', StringValue::fromString('testval4'));
        $attr5 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr5', StringValue::fromString('testval5'));

        $some = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);
        $other = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Other</ssp:Chunk>',
        )->documentElement);
        $sec = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Security</ssp:Chunk>',
        )->documentElement);

        $appliesTo = new AppliesTo(
            [
                new EndpointReference(
                    new Address(
                        AnyURIValue::fromString('http://www.fabrikam123.example.com/acct'),
                    ),
                ),
            ],
            [$attr2],
        );

        $Id = IDValue::fromString('MyId');
        $policy = new Policy([new ExactlyOne([])], [$other], AnyURIValue::fromString('phpunit'), $Id, [$attr3]);

        $policyReference = new PolicyReference(
            AnyURIValue::fromString('urn:x-simplesamlphp:phpunit'),
            Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
            AnyURIValue::fromString('http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc'),
            [$attr4],
        );

        $security = new Security([$sec], [$attr5]);

        $policyAttachment = new PolicyAttachment($appliesTo, [$policy, $policyReference], [$security, $some], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($policyAttachment),
        );
    }
}
