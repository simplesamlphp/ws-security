<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the All element
 *
 * @package simplesamlphp/ws-security
 */
final class All extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
