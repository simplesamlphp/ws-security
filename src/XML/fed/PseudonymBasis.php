<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A PseudonymBasis element
 *
 * @package simplesamlphp/ws-security
 */
final class PseudonymBasis extends AbstractPseudonymBasisType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
