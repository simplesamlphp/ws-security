<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsdl;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWsdlElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_WS_DESCRIPTION_LANGUAGE;

    /** @var string */
    public const NS_PREFIX = 'wsdl';
}
