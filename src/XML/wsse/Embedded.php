<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the Embedded element
 *
 * @package simplesamlphp/ws-security
 */
final class Embedded extends AbstractEmbeddedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
