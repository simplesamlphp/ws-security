<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the UsernameToken element
 *
 * @package simplesamlphp/ws-security
 */
final class UsernameToken extends AbstractUsernameTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
