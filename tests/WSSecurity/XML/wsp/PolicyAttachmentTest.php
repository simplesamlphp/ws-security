<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsp;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\Address;
use SimpleSAML\WSSecurity\XML\wsa\EndpointReference;
use SimpleSAML\WSSecurity\XML\wsp\AbstractWspElement;
use SimpleSAML\WSSecurity\XML\wsp\AppliesTo;
use SimpleSAML\WSSecurity\XML\wsp\ExactlyOne;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\WSSecurity\XML\wsp\PolicyAttachment;
use SimpleSAML\WSSecurity\XML\wsp\PolicyReference;
use SimpleSAML\WSSecurity\XML\wsse\Security;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WSSecurity\XML\wsp\PolicyAttachmentTest
 *
 * @package simplesamlphp/ws-security
 */
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-policy.xsd';

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
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', 'testval3');
        $attr4 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr4', 'testval4');
        $attr5 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr5', 'testval5');

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
            [new EndpointReference(new Address('http://www.fabrikam123.example.com/acct'))],
            [$attr2],
        );

        $policy = new Policy('phpunit', 'MyId', [new ExactlyOne([])], [$other], [$attr3]);

        $policyReference = new PolicyReference(
            'urn:x-simplesamlphp:phpunit',
            '/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=',
            'http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc',
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
