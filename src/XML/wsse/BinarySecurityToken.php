<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the BinarySecurityToken element
 *
 * @package simplesamlphp/ws-security
 */
final class BinarySecurityToken extends AbstractBinarySecurityTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
