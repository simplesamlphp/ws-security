<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

enum IncludeToken: string
{
    case Always = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/Always';
    case AlwaysToInitiator = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/AlwaysToInitiator';
    case AlwaysToRecipient = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/AlwaysToRecipient';
    case Once = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/Once';
    case Never = 'http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/Never';
}
