<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A KeyEchangeToken element
 *
 * @package simplesamlphp/ws-security
 */
final class KeyExchangeToken extends AbstractKeyExchangeTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
