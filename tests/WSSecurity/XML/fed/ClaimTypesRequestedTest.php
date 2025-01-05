<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\auth\ClaimType;
use SimpleSAML\WSSecurity\XML\auth\Description;
use SimpleSAML\WSSecurity\XML\auth\DisplayName;
use SimpleSAML\WSSecurity\XML\auth\DisplayValue;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\WSSecurity\XML\fed\AbstractClaimTypesRequestedType;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\ClaimTypesRequested;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ClaimTypesRequestedTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(ClaimTypesRequested::class)]
#[CoversClass(AbstractClaimTypesRequestedType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClaimTypesRequestedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimTypesRequested::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ClaimTypesRequested.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a PPID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');

        $claimType = new ClaimType(
            C::NAMESPACE,
            true,
            new DisplayName('someDisplayName'),
            new Description('someDescription'),
            new DisplayValue('someDisplayValue'),
            new Value('someValue'),
            [$attr2],
        );

        $claimTypesRequested = new ClaimTypesRequested([$claimType], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimTypesRequested),
        );
    }
}
