<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An RequiredParts element
 *
 * @package simplesamlphp/ws-security
 */
final class RequiredParts extends AbstractReqPartsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
