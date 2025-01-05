<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An attributed URI
 *
 * @package simplesamlphp/ws-security
 */
final class To extends AbstractAttributedURIType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
