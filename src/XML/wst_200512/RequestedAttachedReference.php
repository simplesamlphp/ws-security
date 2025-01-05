<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestedAttachedReference element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestedAttachedReference extends AbstractRequestedReferenceType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
