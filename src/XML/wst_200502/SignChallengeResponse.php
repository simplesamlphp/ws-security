<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An SignChallengeResponse element
 *
 * @package simplesamlphp/ws-security
 */
final class SignChallengeResponse extends AbstractSignChallengeType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
