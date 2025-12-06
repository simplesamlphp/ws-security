<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractTokenAssertionType;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An SslContextToken element
 *
 * @package simplesamlphp/ws-security
 */
final class SslContextToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    /** @var string */
    public const NS = C::NS_MSSP;

    /** @var string */
    public const NS_PREFIX = 'mssp';

    /** @var string */
    public const SCHEMA = 'resources/schemas/mssp.xsd';
}
