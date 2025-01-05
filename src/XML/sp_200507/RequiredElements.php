<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An RequiredElements element
 *
 * @package simplesamlphp/ws-security
 */
final class RequiredElements extends AbstractSerElementsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
