<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequestType element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestType extends AbstractRequestTypeOpenEnum implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
