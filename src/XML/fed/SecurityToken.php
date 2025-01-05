<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A SecurityToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SecurityToken extends AbstractSecurityTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
