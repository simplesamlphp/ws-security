<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType;

/**
 * An Issuer element
 *
 * @package simplesamlphp/ws-security
 */
final class Issuer extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = C::NS_SEC_POLICY;

    /** @var string */
    public const NS_PREFIX = 'sp';
}
