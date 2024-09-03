<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://www.w3.org/2006/05/addressing/wsdl/
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWsawElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_WSDL_ADDR;

    /** @var string */
    public const NS_PREFIX = 'wsaw';
}
