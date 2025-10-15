<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An attributed URI
 *
 * @package simplesamlphp/ws-security
 */
final class MessageID extends AbstractAttributedURIType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
