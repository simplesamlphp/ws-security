<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An endpoint reference
 *
 * @package simplesamlphp/ws-security
 */
final class EndpointReference extends AbstractEndpointReferenceType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
