<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

enum KeyTypeEnum: string
{
    case Bearer = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Bearer';
    case PublicKey = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/PublicKey';
    case SymmetricKey = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/SymmetricKey';
}
