<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

enum StatusCodeEnum: string
{
    case Invalid = 'http://schemas.xmlsoap.org/ws/2005/02/trust/status/invalid';
    case Valid = 'http://schemas.xmlsoap.org/ws/2005/02/trust/status/valid';
}
