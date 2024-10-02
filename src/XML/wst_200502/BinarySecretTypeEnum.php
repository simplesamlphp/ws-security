<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

enum BinarySecretTypeEnum: string
{
    case Asymmetric = 'http://schemas.xmlsoap.org/ws/2005/02/trust/AsymmetricKey';
    case Nonce = 'http://schemas.xmlsoap.org/ws/2005/02/trust/Nonce';
    case Symmetric = 'http://schemas.xmlsoap.org/ws/2005/02/trust/SymmetricKey';
}
