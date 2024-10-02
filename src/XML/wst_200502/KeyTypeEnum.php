<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

enum KeyTypeEnum: string
{
    case PublicKey = 'http://schemas.xmlsoap.org/ws/2005/02/trust/PublicKey';
    case SymmetricKey = 'http://schemas.xmlsoap.org/ws/2005/02/trust/SymmetricKey';
}
