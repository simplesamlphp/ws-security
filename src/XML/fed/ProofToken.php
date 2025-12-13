<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ProofToken element
 *
 * @package simplesamlphp/ws-security
 */
final class ProofToken extends AbstractProofTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
