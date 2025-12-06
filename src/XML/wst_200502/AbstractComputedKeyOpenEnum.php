<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * A ComputedKeyOpenEnum element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractComputedKeyOpenEnum extends AbstractWstElement
{
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;
}
