<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RenewTarget element
 *
 * @package simplesamlphp/ws-security
 */
final class RenewTarget extends AbstractRenewTargetType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
