<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Expires element
 *
 * @package simplesamlphp/ws-security
 */
final class Expires extends AbstractAttributedDateTime implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
