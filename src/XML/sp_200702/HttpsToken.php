<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An HttpsToken element
 *
 * @package simplesamlphp/ws-security
 */
final class HttpsToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
