<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A SignedEndorsingSupportingTokens element
 *
 * @package simplesamlphp/ws-security
 */
final class SignedEndorsingSupportingTokens extends AbstractNestedPolicyType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
