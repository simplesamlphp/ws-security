<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A DelegateTo element
 *
 * @package simplesamlphp/ws-security
 */
final class DelegateTo extends AbstractDelegateToType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
