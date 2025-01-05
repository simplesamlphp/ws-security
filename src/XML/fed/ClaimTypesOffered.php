<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A ClaimTypesOffered element
 *
 * @package simplesamlphp/ws-security
 */
final class ClaimTypesOffered extends AbstractClaimTypesOfferedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
