<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\WebServices\Addressing\XML\wsa_200508\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\Constants as C;

/**
 * An Issuer element
 *
 * @package simplesamlphp/ws-security
 */
final class Issuer extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = C::NS_SEC_POLICY_12;

    /** @var string */
    public const NS_PREFIX = 'sp';

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://www.w3.org/2005/08/addressing', 'Address'],
        ['http://www.w3.org/2005/08/addressing', 'Metadata'],
        ['http://www.w3.org/2005/08/addressing', 'ReferenceParameters'],
    ];
}
