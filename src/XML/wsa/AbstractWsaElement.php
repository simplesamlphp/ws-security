<?php

declare(strict_types=1);

namespace SimpleSAML\WS-Trust\XML\wsa;

use SimpleSAML\XML\AbstractXMLElement;
use SimpleSAML\WS-Trust\Constants;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package tvdijen/ws-trust
 */
abstract class AbstractWsaElement extends AbstractXMLElement
{
    /** @var string */
    public const NS = Constants::NS_ADDR;

    /** @var string */
    public const NS_PREFIX = 'wsa';
}
