<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A CancelTarget element
 *
 * @package simplesamlphp/ws-security
 */
final class CancelTarget extends AbstractCancelTargetType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
