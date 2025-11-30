<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue;

/**
 * A ComputedKeyOpenEnum element
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractComputedKeyOpenEnum extends AbstractWstElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIListValue::class;
}
