<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ClientPseudonym element
 *
 * @package simplesamlphp/ws-security
 */
final class ClientPseudonym extends AbstractClientPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
