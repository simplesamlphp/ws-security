<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Pseudonym element
 *
 * @package simplesamlphp/ws-security
 */
final class Pseudonym extends AbstractPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
