<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

enum AnonymousEnum: string
{
    case Optional = 'optional';
    case Prohibited = 'prohibited';
    case Required = 'required';
}
