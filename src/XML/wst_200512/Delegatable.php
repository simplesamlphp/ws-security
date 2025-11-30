<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Type\BooleanValue;

/**
 * A Delegatable element
 *
 * @package simplesamlphp/ws-security
 */
final class Delegatable extends AbstractWstElement implements SchemaValidatableElementInterface
{
    use TypedTextContentTrait;
    use SchemaValidatableElementTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = BooleanValue::class;
}
