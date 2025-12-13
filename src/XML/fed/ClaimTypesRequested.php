<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ClaimTypesRequested element
 *
 * @package simplesamlphp/ws-security
 */
final class ClaimTypesRequested extends AbstractClaimTypesRequestedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
