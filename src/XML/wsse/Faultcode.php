<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

enum Faultcode: string
{
    case UnsupportedSecurityToken = 'wsse:UnsupportedSecurityToken';
    case UnsupportedAlgorithm = 'wsse:UnsupportedAlgorithm';
    case InvalidSecurity = 'wsse:InvalidSecurity';
    case InvalidSecurityToken = 'wsse:InvalidSecurityToken';
    case FailedAuthentication = 'wsse:FailedAuthentication';
    case FailedCheck = 'wsse:FailedCheck';
    case SecurityTokenUnavailable = 'wsse:SecurityTokenUnavailable';
}
