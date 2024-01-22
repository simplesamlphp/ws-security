<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

enum RequestTypeEnum: string
{
    case Cancel = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Cancel';
    case Issue = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Issue';
    case Renew = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Renew';
    case STSCancel = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/STSCancel';
    case Validate = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Validate';
}
