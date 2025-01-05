<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWspElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_POLICY;

    /** @var string */
    public const NS_PREFIX = 'wsp';

    /** @var string */
    public const SCHEMA = 'resources/schemas/ws-policy-200409.xsd';
}
