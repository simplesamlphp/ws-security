<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestSecurityToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestSecurityToken extends AbstractRequestSecurityTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
