<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A FederationMetadataHandler element
 *
 * @package simplesamlphp/ws-security
 */
final class FederationMetadataHandler extends AbstractFederationMetadataHandlerType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
