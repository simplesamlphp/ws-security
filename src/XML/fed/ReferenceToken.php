<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A ReferenceToken element
 *
 * @package simplesamlphp/ws-security
 */
final class ReferenceToken extends AbstractReferenceTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
