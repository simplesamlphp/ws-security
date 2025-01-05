<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestPseudonym element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestPseudonym extends AbstractRequestPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
