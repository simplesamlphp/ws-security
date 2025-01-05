<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An Entropy element
 *
 * @package simplesamlphp/ws-security
 */
final class Entropy extends AbstractEntropyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
