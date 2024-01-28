<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWstElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_TRUST;

    /** @var string */
    public const NS_PREFIX = 'wst';
}
