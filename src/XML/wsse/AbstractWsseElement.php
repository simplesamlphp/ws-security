<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://docs.oasis-open.org/wss/v1.1/wss-v1.1-spec-pr-SOAPMessageSecurity-01.htm#_Toc106443153
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWsseElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SEC_EXT;

    /** @var string */
    public const NS_PREFIX = 'wsse';
}
