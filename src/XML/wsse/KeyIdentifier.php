<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the KeyIdentifier element
 *
 * @package simplesamlphp/ws-security
 */
final class KeyIdentifier extends AbstractKeyIdentifierType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
