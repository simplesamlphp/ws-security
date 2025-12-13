<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A Renewing element
 *
 * @package simplesamlphp/ws-security
 */
final class Renewing extends AbstractRenewingType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
