<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An attributed QName
 *
 * @package simplesamlphp/ws-security
 */
final class ProblemHeaderQName extends AbstractAttributedQNameType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
