<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSpElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SEC_POLICY_11;

    /** @var string */
    public const NS_PREFIX = 'sp';

    /** @var string */
    public const SCHEMA = 'resources/schemas/ws-securitypolicy-1.1.xsd';
}
