<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Timestamp element
 *
 * @package simplesamlphp/ws-security
 */
final class Timestamp extends AbstractTimestamp implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
