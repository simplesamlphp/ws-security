<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

enum IncludeToken: string
{
    case Always = 'http://schemas.xmlsoap.org/ws/2005/07/securitypolicy/IncludeToken/Always';
    case AlwaysToRecipient = 'http://schemas.xmlsoap.org/ws/2005/07/securitypolicy/IncludeToken/AlwaysToRecipient';
    case Once = 'http://schemas.xmlsoap.org/ws/2005/07/securitypolicy/IncludeToken/Once';
    case Never = 'http://schemas.xmlsoap.org/ws/2005/07/securitypolicy/IncludeToken/Never';
}
