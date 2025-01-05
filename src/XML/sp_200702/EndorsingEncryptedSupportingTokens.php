<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A EndorsingEncryptedSupportingTokens element
 *
 * @package simplesamlphp/ws-security
 */
final class EndorsingEncryptedSupportingTokens extends AbstractNestedPolicyType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
