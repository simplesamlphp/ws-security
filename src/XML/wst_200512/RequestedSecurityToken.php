<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestedSecurityToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestedSecurityToken extends AbstractRequestedSecurityTokenType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
