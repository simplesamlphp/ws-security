<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\WSSecurity\Constants;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractWsaElement extends AbstractElement
{
    /** @var string */
    public const NS = Constants::NS_ADDR;

    /** @var string */
    public const NS_PREFIX = 'wsa';
}
