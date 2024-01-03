<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\sp\AbstractNestedPolicyType;

/**
 * An AuthenticationToken element
 *
 * @package tvdijen/ws-security
 */
final class AuthenticationToken extends AbstractNestedPolicyType
{
    /** @var string */
    public const NS = AbstractFedElement::NS;

    /** @var string */
    public const NS_PREFIX = AbstractFedElement::NS_PREFIX;
}
