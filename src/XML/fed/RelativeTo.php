<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RelativeTo element
 *
 * @package simplesamlphp/ws-security
 */
final class RelativeTo extends AbstractRelativeToType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
