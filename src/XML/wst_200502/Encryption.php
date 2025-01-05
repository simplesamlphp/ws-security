<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Encryption element
 *
 * @package simplesamlphp/ws-security
 */
final class Encryption extends AbstractEncryptionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
