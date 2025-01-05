<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * @package simplesamlphp/ws-security
 */
final class RetryAfter extends AbstractRetryAfterType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
