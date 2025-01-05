<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestedProofToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestedProofToken extends AbstractRequestedProofTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
