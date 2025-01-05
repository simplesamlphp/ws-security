<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing WS-authorization AdditionalContext.
 *
 * @package simplesamlphp/ws-security
 */
final class AdditionalContext extends AbstractAdditionalContextType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
