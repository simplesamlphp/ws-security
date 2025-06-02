<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XML\Type\BooleanValue;

/**
 * A AutomaticPseudonyms element
 *
 * @package simplesamlphp/ws-security
 */
final class AutomaticPseudonyms extends AbstractFedElement implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = BooleanValue::class;
}
