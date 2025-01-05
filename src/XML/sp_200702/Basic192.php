<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An Basic192 element
 *
 * @package simplesamlphp/ws-security
 */
final class Basic192 extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
