<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ProtectionToken element
 *
 * @package simplesamlphp/ws-security
 */
final class ProtectionToken extends AbstractNestedPolicyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
