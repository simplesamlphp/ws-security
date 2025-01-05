<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An MustNotSendCancel element
 *
 * @package simplesamlphp/ws-security
 */
final class MustNotSendCancel extends AbstractQNameAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const NS = C::NS_MSSP;

    /** @var string */
    public const NS_PREFIX = 'mssp';

    /** @var string */
    public const SCHEMA = 'resources/schemas/mssp.xsd';
}
