<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

enum ComputedKeyEnum: string
{
    case HASH = 'http://schemas.xmlsoap.org/ws/2005/02/trust/CK/HASH';
    case PSHA1 = 'http://schemas.xmlsoap.org/ws/2005/02/trust/CK/PSHA1';
}
