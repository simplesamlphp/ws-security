<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestSecurityTokenResponse element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestSecurityTokenResponse extends AbstractRequestSecurityTokenResponseType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
