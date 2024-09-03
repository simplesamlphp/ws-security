<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\XML\sp_200507\AbstractTokenAssertionType;

/**
 * An RsaToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RsaToken extends AbstractTokenAssertionType
{
    /** @var string */
    public const NS_PREFIX = 'mssp';
}
