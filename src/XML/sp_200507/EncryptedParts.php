<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An EncryptedParts element
 *
 * @package simplesamlphp/ws-security
 */
final class EncryptedParts extends AbstractSePartsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
