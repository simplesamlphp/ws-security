<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

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
    public const NS = C::NS_TRUST_200502;

    /** @var string */
    public const NS_PREFIX = 't';

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://schemas.xmlsoap.org/ws/2004/08/addressing', 'Address'],
        ['http://schemas.xmlsoap.org/ws/2004/08/addressing', 'ReferenceParameters'],
    ];
}
