<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\WSSecurity\Constants as C;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://docs.oasis-open.org/wss/v1.1/wss-v1.1-spec-pr-SOAPMessageSecurity-01.htm#_Toc106443153
 * @package tvdijen/ws-security
 */
abstract class AbstractWsuElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SEC_UTIL;

    /** @var string */
    public const NS_PREFIX = 'wsu';
}
