<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the ClaimDialectsOffered element
 *
 * @package simplesamlphp/ws-security
 */
final class ClaimDialectsOffered extends AbstractClaimDialectsOfferedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
