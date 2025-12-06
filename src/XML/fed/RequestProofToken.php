<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequestProofToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestProofToken extends AbstractRequestProofTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
