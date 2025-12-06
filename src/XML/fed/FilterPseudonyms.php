<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FilterPseudonyms element
 *
 * @package simplesamlphp/ws-security
 */
final class FilterPseudonyms extends AbstractFilterPseudonymsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
