<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\WebServices\Addressing\XML\wsa_200408\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An Issuer element
 *
 * @package simplesamlphp/ws-security
 */
final class Issuer extends AbstractEndpointReferenceType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    /** @var string */
    public const NS = C::NS_TRUST_200502;

    /** @var string */
    public const NS_PREFIX = AbstractWstElement::NS_PREFIX;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://schemas.xmlsoap.org/ws/2004/08/addressing', 'Address'],
        ['http://schemas.xmlsoap.org/ws/2004/08/addressing', 'ReferenceParameters'],
    ];

    /** @var string */
    public const SCHEMA = AbstractWstElement::SCHEMA;
}
