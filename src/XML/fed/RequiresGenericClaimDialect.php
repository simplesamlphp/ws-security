<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\fed\AbstractAssertionType;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequiresGenericClaimDialect element
 *
 * @package simplesamlphp/ws-security
 */
final class RequiresGenericClaimDialect extends AbstractAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
