<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing WS-authorization ClaimType.
 *
 * @package simplesamlphp/ws-security
 */
final class ClaimType extends AbstractClaimType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
