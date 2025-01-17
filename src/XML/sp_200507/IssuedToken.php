<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An IssuedToken element
 *
 * @package simplesamlphp/ws-security
 */
final class IssuedToken extends AbstractIssuedTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
