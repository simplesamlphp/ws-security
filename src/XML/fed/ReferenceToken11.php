<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\fed\AbstractAssertionType;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A ReferenceToken11 element
 *
 * @package simplesamlphp/ws-security
 */
final class ReferenceToken11 extends AbstractAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
