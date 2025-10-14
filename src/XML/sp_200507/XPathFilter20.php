<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An XPathFilter20 element
 *
 * @package simplesamlphp/ws-security
 */
final class XPathFilter20 extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
