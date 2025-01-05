<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the PseudonymServiceEndpointz element
 *
 * @package simplesamlphp/ws-security
 */
final class PseudonymServiceEndpoints extends AbstractEndpointType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
