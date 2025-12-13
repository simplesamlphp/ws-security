<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An RequireKeyIdentifierReference element
 *
 * @package simplesamlphp/ws-security
 */
final class RequireKeyIdentifierReference extends AbstractQNameAssertionType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
