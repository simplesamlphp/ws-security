<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Security element
 *
 * @package simplesamlphp/ws-security
 */
final class Security extends AbstractSecurityHeaderType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
