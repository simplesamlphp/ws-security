<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A UseKey element
 *
 * @package simplesamlphp/ws-security
 */
final class UseKey extends AbstractUseKeyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
