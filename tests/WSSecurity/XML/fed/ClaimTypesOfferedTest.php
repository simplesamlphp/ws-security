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
use SimpleSAML\WSSecurity\XML\fed\AbstractClaimTypesOfferedType;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\ClaimTypesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\fed\ClaimTypesOfferedTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(ClaimTypesOffered::class)]
#[CoversClass(AbstractClaimTypesOfferedType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClaimTypesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimTypesOffered::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_ClaimTypesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a PPID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('testval2'));

        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr2],
        );

        $claimTypesOffered = new ClaimTypesOffered([$claimType], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimTypesOffered),
        );
    }
}
