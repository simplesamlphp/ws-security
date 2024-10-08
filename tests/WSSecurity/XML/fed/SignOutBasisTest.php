<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractSignOutBasisType;
use SimpleSAML\WSSecurity\XML\fed\SignOutBasis;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:SignOutBasis.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(SignOutBasis::class)]
#[CoversClass(AbstractSignOutBasisType::class)]
#[CoversClass(AbstractFedElement::class)]
final class SignOutBasisTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SignOutBasis::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_SignOutBasis.xml',
        );

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating an SignOutBasis object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $signOutBasis = new SignOutBasis(
            [self::$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signOutBasis),
        );
    }
}
