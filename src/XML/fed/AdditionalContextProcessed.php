<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An AdditionalContextProcessed element
 *
 * @package simplesamlphp/ws-security
 */
final class AdditionalContextProcessed extends AbstractAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
