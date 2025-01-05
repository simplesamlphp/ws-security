<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestProofToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestProofToken extends AbstractRequestProofTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
