<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An MustSupportIssuedTokens element
 *
 * @package simplesamlphp/ws-security
 */
final class MustSupportIssuedTokens extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
