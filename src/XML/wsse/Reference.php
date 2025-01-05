<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the Reference element
 *
 * @package simplesamlphp/ws-security
 */
final class Reference extends AbstractReferenceType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
