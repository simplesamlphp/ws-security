<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the LogicalServiceNamesOffered element
 *
 * @package simplesamlphp/ws-security
 */
final class LogicalServiceNamesOffered extends AbstractLogicalServiceNamesOfferedType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
