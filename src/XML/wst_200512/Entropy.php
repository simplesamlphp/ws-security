<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An Entropy element
 *
 * @package simplesamlphp/ws-security
 */
final class Entropy extends AbstractEntropyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
