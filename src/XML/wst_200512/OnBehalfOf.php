<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A OnBehalfOf element
 *
 * @package simplesamlphp/ws-security
 */
final class OnBehalfOf extends AbstractOnBehalfOfType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
