<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

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
    public const NS = C::NS_ADDR_200408;

    /** @var string */
    public const NS_PREFIX = 'wsa';

    /** @var string */
    public const SCHEMA = 'resources/schemas/ws-addr-200408.xsd';
}
