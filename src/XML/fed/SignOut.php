<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the SignOut element
 *
 * @package simplesamlphp/ws-security
 */
final class SignOut extends AbstractSignOutType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
