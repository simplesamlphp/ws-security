<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An SignChallenge element
 *
 * @package simplesamlphp/ws-security
 */
final class SignChallenge extends AbstractSignChallengeType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
