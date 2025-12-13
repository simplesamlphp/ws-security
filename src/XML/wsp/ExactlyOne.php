<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the ExactlyOne element
 *
 * @package simplesamlphp/ws-security
 */
final class ExactlyOne extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
