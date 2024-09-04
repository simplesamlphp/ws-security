<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\wsa_200508\AbstractEndpointReferenceType;

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
}
