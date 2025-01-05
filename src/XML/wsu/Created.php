<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the Created element
 *
 * @package simplesamlphp/ws-security
 */
final class Created extends AbstractAttributedDateTime implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
