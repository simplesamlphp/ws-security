<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FederationID element
 *
 * @package simplesamlphp/ws-security
 */
final class FederationID extends AbstractAttributeExtensibleURI implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
