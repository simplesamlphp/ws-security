<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use SimpleSAML\XML\Type\StringValue;
use SimpleSAML\XML\TypedTextContentTrait;

/**
 * Class representing WS-authorization Value.
 *
 * @package simplesamlphp/ws-security
 */
final class Value extends AbstractAuthElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = StringValue::class;
}
