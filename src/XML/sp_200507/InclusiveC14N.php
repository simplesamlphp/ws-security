<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An InclusiveC14N element
 *
 * @package simplesamlphp/ws-security
 */
final class InclusiveC14N extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
