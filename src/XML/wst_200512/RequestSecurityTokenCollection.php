<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestSecurityTokenCollection element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestSecurityTokenCollection extends AbstractRequestSecurityTokenCollectionType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
