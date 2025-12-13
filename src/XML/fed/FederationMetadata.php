<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FederationMetadata element
 *
 * @package simplesamlphp/ws-security
 */
final class FederationMetadata extends AbstractFederationMetadataType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
