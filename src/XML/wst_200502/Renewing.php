<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Renewing element
 *
 * @package simplesamlphp/ws-security
 */
final class Renewing extends AbstractRenewingType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
