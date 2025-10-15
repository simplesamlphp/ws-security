<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An attributed long
 *
 * @package simplesamlphp/ws-security
 */
final class RetryAfter extends AbstractAttributedUnsignedLongType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
