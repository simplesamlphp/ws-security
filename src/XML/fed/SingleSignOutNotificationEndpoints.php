<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the SingleSignOutNotificationEndpoints element
 *
 * @package simplesamlphp/ws-security
 */
final class SingleSignOutNotificationEndpoints extends AbstractEndpointType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
