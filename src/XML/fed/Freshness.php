<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Freshness element
 *
 * @package simplesamlphp/ws-security
 */
final class Freshness extends AbstractFreshnessType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
