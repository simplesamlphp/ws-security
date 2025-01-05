<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the SecurityTokenReference element
 *
 * @package simplesamlphp/ws-security
 */
final class SecurityTokenReference extends AbstractSecurityTokenReferenceType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
