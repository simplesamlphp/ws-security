<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A ComputedKey element
 *
 * @package simplesamlphp/ws-security
 */
final class ComputedKey extends AbstractComputedKeyOpenEnum implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
