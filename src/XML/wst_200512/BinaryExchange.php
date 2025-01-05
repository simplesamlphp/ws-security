<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A BinaryExchange element
 *
 * @package simplesamlphp/ws-security
 */
final class BinaryExchange extends AbstractBinaryExchangeType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
