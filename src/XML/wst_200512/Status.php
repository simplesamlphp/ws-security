<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Status element
 *
 * @package simplesamlphp/ws-security
 */
final class Status extends AbstractStatusType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
