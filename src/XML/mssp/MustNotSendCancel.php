<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;

/**
 * An MustNotSendCancel element
 *
 * @package simplesamlphp/ws-security
 */
final class MustNotSendCancel extends AbstractQNameAssertionType
{
    /** @var string */
    public const NS_PREFIX = 'mssp';
}
