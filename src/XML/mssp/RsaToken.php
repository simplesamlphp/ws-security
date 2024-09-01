<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\AbstractTokenAssertionType;

/**
 * An RsaToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RsaToken extends AbstractTokenAssertionType
{
    /** @var string */
    public const NS = C::NS_WS_SEC;

    /** @var string */
    public const NS_PREFIX = 'mssp';
}
