<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;

/**
 * An RequireClientCertificate element
 *
 * @package simplesamlphp/ws-security
 */
final class RequireClientCertificate extends AbstractQNameAssertionType
{
    /** @var string */
    public const NS_PREFIX = 'mssp';
}
