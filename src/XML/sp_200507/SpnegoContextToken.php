<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An SpnegoContextToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SpnegoContextToken extends AbstractSpnegoContextTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
