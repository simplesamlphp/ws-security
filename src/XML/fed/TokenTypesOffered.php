<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the TokenTypesOffered element
 *
 * @package simplesamlphp/ws-security
 */
final class TokenTypesOffered extends AbstractTokenTypesOfferedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
