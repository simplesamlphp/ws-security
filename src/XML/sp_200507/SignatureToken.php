<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A SignatureToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SignatureToken extends AbstractNestedPolicyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
