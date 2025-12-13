<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Nonce element
 *
 * @package simplesamlphp/ws-security
 */
final class Nonce extends AbstractEncodedString implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
