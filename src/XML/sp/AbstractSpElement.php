<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\WSSecurity\Constants as C;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractSpElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SEC_POLICY;

    /** @var string */
    public const NS_PREFIX = 'sp';
}
