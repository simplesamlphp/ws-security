<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity;

/**
 * Class holding constants relevant for WS-Security.
 *
 * @package simplesamlphp/ws-security
 */

class Constants extends \SimpleSAML\SAML2\Constants
{
    /**
     * The namespace for WS-Authorization protocol.
     */
    public const NS_AUTH = 'http://docs.oasis-open.org/wsfed/authorization/200706';

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
    public const NS_TRUST_200502 = 'http://schemas.xmlsoap.org/ws/2005/02/trust';

    public const NS_TRUST_200512 = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/';

    /**
     * The namespace for WS-Security extensions.
     */
    public const NS_SEC_EXT = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    /**
     * The namespace for the Web Service Security Policy protocol.
     */
    public const NS_SEC_POLICY_11 = 'http://schemas.xmlsoap.org/ws/2005/07/securitypolicy';

    public const NS_SEC_POLICY_12 = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702';

    /**
     * The namespace for WS-Security utilities protocol.
     */
    public const NS_SEC_UTIL = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';

    /**
     * The namespace for the Metadata Exchange protocol.
     */
    public const NS_METADATA_EXCHANGE = 'http://schemas.xmlsoap.org/ws/2004/09/mex';

    /**
     * The namespace for the Microsoft Security Policy protocol.
     */
    public const NS_MSSP = 'http://schemas.microsoft.com/ws/2005/07/securitypolicy';

    /**
     * The schema-defined wsa fault codes
     */
    public const WSA_FAULT_INVALID_ADDRESSING_HEADER = 'InvalidAddressingHeader';

    public const WSA_FAULT_INVALID_ADDRESS = 'InvalidAddress';

    public const WSA_FAULT_INVALID_EPR = 'InvalidEPR';

    public const WSA_FAULT_INVALID_CARDINALITY = 'InvalidCardinality';

    public const WSA_FAULT_MISSING_ADDRESS_IN_EPR = 'MissingAddressInEPR';

    public const WSA_FAULT_DUPLICATE_MESSAGEID = 'DupicateMessageID';

    public const WSA_FAULT_ACTION_MISMATCH = 'ActionMismatch';

    public const WSA_FAULT_MESSAGE_ADDRESSING_HEADER_REQUIRED = 'MessageAddressingHeaderRequired';

    public const WSA_FAULT_DESTINATION_UNREACHABLE = 'DestinationUnreachable';

    public const WSA_FAULT_ACTION_NOT_SUPPORTED = 'ActionNotSupported';

    public const WSA_FAULT_ENDPOINT_UNAVAILABLE = 'EndpointUnavailable';

    public const FAULT_CODES = [
        self::WSA_FAULT_INVALID_ADDRESSING_HEADER,
        self::WSA_FAULT_INVALID_ADDRESS,
        self::WSA_FAULT_INVALID_EPR,
        self::WSA_FAULT_INVALID_CARDINALITY,
        self::WSA_FAULT_MISSING_ADDRESS_IN_EPR,
        self::WSA_FAULT_DUPLICATE_MESSAGEID,
        self::WSA_FAULT_ACTION_MISMATCH,
        self::WSA_FAULT_MESSAGE_ADDRESSING_HEADER_REQUIRED,
        self::WSA_FAULT_DESTINATION_UNREACHABLE,
        self::WSA_FAULT_ACTION_NOT_SUPPORTED,
        self::WSA_FAULT_ENDPOINT_UNAVAILABLE,
    ];

    /**
     */
    public const WST_REFID_PIN = 'http://docs.oasis-open.org/ws-sx/ws-trust/200802/challenge/PIN';

    public const WST_REFID_OTP = 'http://docs.oasis-open.org/ws-sx/ws-trust/200802/challenge/OTP';

    /**
     */
    public const WSU_TIMESTAMP_FAULT = 'MessageExpired';

    /**
     * The format to express a timestamp in SAML2
     */
    public const DATETIME_FORMAT = 'Y-m-d\\TH:i:sp';
}
