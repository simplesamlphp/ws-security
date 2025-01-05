<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An SignedParts element
 *
 * @package simplesamlphp/ws-security
 */
final class SignedParts extends AbstractSePartsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
