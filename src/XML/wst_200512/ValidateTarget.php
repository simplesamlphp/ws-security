<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A ValidateTarget element
 *
 * @package simplesamlphp/ws-security
 */
final class ValidateTarget extends AbstractValidateTargetType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
