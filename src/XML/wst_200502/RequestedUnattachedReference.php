<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequestedUnattachedReference element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestedUnattachedReference extends AbstractRequestedReferenceType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
