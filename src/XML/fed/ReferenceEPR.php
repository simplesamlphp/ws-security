<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WebServices\Addressing\XML\wsa_200508\AbstractEndpointReferenceType;

/**
 * A ReferenceEPR element
 *
 * @package simplesamlphp/ws-security
 */
final class ReferenceEPR extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = AbstractFedElement::NS;

    /** @var string */
    public const NS_PREFIX = AbstractFedElement::NS_PREFIX;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://www.w3.org/2005/08/addressing', 'Address'],
        ['http://www.w3.org/2005/08/addressing', 'Metadata'],
        ['http://www.w3.org/2005/08/addressing', 'ReferenceParameters'],
    ];
}
