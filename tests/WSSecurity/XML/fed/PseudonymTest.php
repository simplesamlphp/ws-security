<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractPseudonymType;
use SimpleSAML\WSSecurity\XML\fed\ProofToken;
use SimpleSAML\WSSecurity\XML\fed\Pseudonym;
use SimpleSAML\WSSecurity\XML\fed\PseudonymBasis;
use SimpleSAML\WSSecurity\XML\fed\RelativeTo;
use SimpleSAML\WSSecurity\XML\fed\SecurityToken;
use SimpleSAML\WSSecurity\XML\wsu\Expires;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Utils\XPath;

use function dirname;
use function strval;

/**
 * Tests for fed:Pseudonym.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(Pseudonym::class)]
#[CoversClass(AbstractPseudonymType::class)]
#[CoversClass(AbstractFedElement::class)]
final class PseudonymTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $basis */
    protected static Chunk $basis;

    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;

    /** @var \SimpleSAML\XML\Chunk $proof */
    protected static Chunk $proof;

    /** @var \SimpleSAML\XML\Chunk $relative */
    protected static Chunk $relative;

    /** @var \SimpleSAML\XML\Chunk $security */
    protected static Chunk $security;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Pseudonym::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_Pseudonym.xml',
        );

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        self::$basis = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Basis</ssp:Chunk>',
        )->documentElement);

        self::$relative = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Relative</ssp:Chunk>',
        )->documentElement);

        self::$security = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Security</ssp:Chunk>',
        )->documentElement);

        self::$proof = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Proof</ssp:Chunk>',
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating an Pseudonym object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'testval3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'testval4');
        $attr5 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr5', 'testval5');

        $pseudonymBasis = new PseudonymBasis(
            self::$basis,
            [$attr2],
        );

        $relativeTo = new RelativeTo(
            [self::$relative],
            [$attr3],
        );

        $expires = new Expires(new DateTimeImmutable('2001-10-13T09:00:00Z'));

        $securityToken = new SecurityToken(
            self::$security,
            [$attr4],
        );

        $proofToken = new ProofToken(
            self::$proof,
            [$attr5],
        );

        $pseudonym = new Pseudonym(
            $pseudonymBasis,
            $relativeTo,
            [$expires, $securityToken, $proofToken, self::$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($pseudonym),
        );
    }


    /**
     */
    public function testMarshallingElementOrder(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'testval2');
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'testval3');
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'testval4');
        $attr5 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr5', 'testval5');

        $pseudonymBasis = new PseudonymBasis(
            self::$basis,
            [$attr2],
        );

        $relativeTo = new RelativeTo(
            [self::$relative],
            [$attr3],
        );

        $expires = new Expires(new DateTimeImmutable('2001-10-13T09:00:00Z'));

        $securityToken = new SecurityToken(
            self::$security,
            [$attr4],
        );

        $proofToken = new ProofToken(
            self::$proof,
            [$attr5],
        );

        $pseudonym = new Pseudonym(
            $pseudonymBasis,
            $relativeTo,
            [$expires, $securityToken, $proofToken, self::$chunk],
            [$attr1],
        );
        $pseudonymElement = $pseudonym->toXML();

        // Test for a PseudonymBasis
        $xpCache = XPath::getXPath($pseudonymElement);
        $pseudonymBasisElements = XPath::xpQuery($pseudonymElement, './fed:PseudonymBasis', $xpCache);
        $this->assertCount(1, $pseudonymBasisElements);

        // Test ordering of Pseudonym contents
        /** @psalm-var \DOMElement[] $pseudonymElements */
        $pseudonymElements = XPath::xpQuery($pseudonymElement, './fed:PseudonymBasis/following-sibling::*', $xpCache);
        $this->assertCount(5, $pseudonymElements);
        $this->assertEquals('fed:RelativeTo', $pseudonymElements[0]->tagName);
        $this->assertEquals('wsu:Expires', $pseudonymElements[1]->tagName);
        $this->assertEquals('fed:SecurityToken', $pseudonymElements[2]->tagName);
        $this->assertEquals('fed:ProofToken', $pseudonymElements[3]->tagName);
        $this->assertEquals('ssp:Chunk', $pseudonymElements[4]->tagName);
    }
}
