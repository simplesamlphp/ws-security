<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see http://docs.oasis-open.org/wsfed/federation/v1.2/os/ws-federation-1.2-spec-os.pdf
 * @package tvdijen/ws-security
 */
abstract class AbstractAuthElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_AUTH;

    /** @var string */
    public const NS_PREFIX = 'auth';
}
