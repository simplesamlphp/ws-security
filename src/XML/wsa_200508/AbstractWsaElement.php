<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWsaElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_ADDR_200508;

    /** @var string */
    public const NS_PREFIX = 'wsa10';
}
