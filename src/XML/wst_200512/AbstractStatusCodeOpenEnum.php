<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * A StatusCodeOpenEnum element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractStatusCodeOpenEnum extends AbstractWstElement
{
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;
}
