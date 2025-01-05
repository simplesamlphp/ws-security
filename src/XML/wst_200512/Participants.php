<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Participants element
 *
 * @package simplesamlphp/ws-security
 */
final class Participants extends AbstractParticipantsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
