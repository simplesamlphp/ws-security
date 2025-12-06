<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ComputedKey element
 *
 * @package simplesamlphp/ws-security
 */
final class ComputedKey extends AbstractComputedKeyOpenEnum implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
