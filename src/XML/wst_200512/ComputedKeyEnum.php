<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

enum ComputedKeyEnum: string
{
    case HASH = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/CK/HASH';
    case PSHA1 = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/CK/PSHA1';
}
