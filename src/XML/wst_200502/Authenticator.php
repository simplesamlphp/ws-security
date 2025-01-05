<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An Authenticator element
 *
 * @package simplesamlphp/ws-security
 */
final class Authenticator extends AbstractAuthenticatorType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
