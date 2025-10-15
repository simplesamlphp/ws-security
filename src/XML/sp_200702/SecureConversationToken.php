<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An SecureConversationToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SecureConversationToken extends AbstractSecureConversationTokenType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
