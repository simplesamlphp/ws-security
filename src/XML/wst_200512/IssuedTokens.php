<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A IssuedTokens element
 *
 * @package simplesamlphp/ws-security
 */
final class IssuedTokens extends AbstractRequestSecurityTokenResponseCollectionType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
