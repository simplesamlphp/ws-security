<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A TransportToken element
 *
 * @package simplesamlphp/ws-security
 */
final class TransportToken extends AbstractNestedPolicyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
