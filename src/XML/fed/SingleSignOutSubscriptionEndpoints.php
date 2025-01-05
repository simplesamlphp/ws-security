<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the SingleSignOutSubscriptionEndpoints element
 *
 * @package simplesamlphp/ws-security
 */
final class SingleSignOutSubscriptionEndpoints extends AbstractEndpointType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
