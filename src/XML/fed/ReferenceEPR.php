<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\wsa\AbstractEndpointReferenceType;

/**
 * A ReferenceEPR element
 *
 * @package tvdijen/ws-security
 */
final class ReferenceEPR extends AbstractEndpointReferenceType
{
    /** @var string */
    public const NS = AbstractFedElement::NS;

    /** @var string */
    public const NS_PREFIX = AbstractFedElement::NS_PREFIX;
}
