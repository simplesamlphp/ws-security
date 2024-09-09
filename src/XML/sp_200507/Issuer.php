<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractEndpointReferenceType;

/**
 * An Issuer element
 *
 * @package simplesamlphp/ws-security
 */
final class Issuer extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = C::NS_SEC_POLICY_11;

    /** @var string */
    public const NS_PREFIX = 'sp';
}
