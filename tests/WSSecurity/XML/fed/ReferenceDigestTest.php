<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractReferenceDigestType;
use SimpleSAML\WSSecurity\XML\fed\ReferenceDigest;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ReferenceDigestTest
 *
 * @package simplesamlphp/ws-security
 */
#[CoversClass(ReferenceDigest::class)]
#[CoversClass(AbstractReferenceDigestType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ReferenceDigestTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceDigest::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ReferenceDigest.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ReferenceDigest object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $referenceDigest = new ReferenceDigest('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceDigest),
        );
    }
}
