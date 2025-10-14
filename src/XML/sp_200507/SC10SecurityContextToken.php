<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An SC10SecurityContextToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SC10SecurityContextToken extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
