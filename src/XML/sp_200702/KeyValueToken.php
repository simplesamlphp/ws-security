<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An KeyValueToken element
 *
 * @package simplesamlphp/ws-security
 */
final class KeyValueToken extends AbstractKeyValueTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
