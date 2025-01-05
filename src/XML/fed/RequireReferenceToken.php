<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\WSSecurity\XML\sp_200702\AbstractTokenAssertionType;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An RequireReferenceToken element
 *
 * @package simplesamlphp/ws-security
 */
final class RequireReferenceToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const NS = AbstractFedElement::NS;

    /** @var string */
    public const NS_PREFIX = AbstractFedElement::NS_PREFIX;

    /** @var string */
    public const SCHEMA = AbstractFedElement::SCHEMA;
}
