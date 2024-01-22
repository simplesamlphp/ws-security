<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

enum BinarySecretTypeEnum: string
{
    case Asymmetric = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/AsymmetricKey';
    case Nonce = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/Nonce';
    case Symmetric = 'http://docs.oasis-open.org/ws-sx/ws-trust/200512/SymmetricKey';
}
