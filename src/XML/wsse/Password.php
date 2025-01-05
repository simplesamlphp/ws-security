<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the Password element
 *
 * @package simplesamlphp/ws-security
 */
final class Password extends AbstractPasswordString implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
