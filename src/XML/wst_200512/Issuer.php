<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractEndpointReferenceType;

/**
 * An Issuer element
 *
 * @package simplesamlphp/ws-security
 */
final class Issuer extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = C::NS_TRUST_200512;

    /** @var string */
    public const NS_PREFIX = 'wst';

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://www.w3.org/2005/08/addressing', 'Address'],
        ['http://www.w3.org/2005/08/addressing', 'Metadata'],
        ['http://www.w3.org/2005/08/addressing', 'ReferenceParameters'],
    ];
}
