<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An SamlToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SamlToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
