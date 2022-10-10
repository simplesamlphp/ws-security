<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity;

/**
 * Class holding constants relevant for WS-Security.
 *
 * @package tvdijen/ws-security
 */

class Constants extends \SimpleSAML\XMLSecurity\Constants
{
    /**
     * The namespace for WS-Addressing protocol.
     */
    public const NS_ADDR = 'http://www.w3.org/2005/08/addressing';

    /**
     * The namespace for WS-Federation protocol.
     */
    public const NS_FED = 'http://docs.oasis-open.org/wsfed/federation/200706';

    /**
     * The namespace for WS-Policy protocol.
     */
    public const NS_POLICY = 'http://schemas.xmlsoap.org/ws/2004/09/policy';

    /**
     * The namespace for WS-Trust protocol.
     */
    public const NS_TRUST = 'http://schemas.xmlsoap.org/ws/2005/02/trust';

    /**
     * The namespace for WS-Security utilities protocol.
     */
    public const NS_SEC_UTIL = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';

    /**
     * The namespace for the SOAP protocol.
     */
    public const NS_SOAP = 'http://schemas.xmlsoap.org/soap/envelope';
}
