<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestSecurityTokenResponseCollection element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestSecurityTokenResponseCollection extends AbstractRequestSecurityTokenResponseCollectionType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
