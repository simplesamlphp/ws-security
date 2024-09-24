<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

enum StatusCodeEnum: string
{
    case Invalid = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/status/invalid';
    case Valid = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/status/valid';
}
