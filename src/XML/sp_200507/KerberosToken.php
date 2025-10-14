<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An KerberosToken element
 *
 * @package simplesamlphp/ws-security
 */
final class KerberosToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
