<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the TransformationParameters element
 *
 * @package simplesamlphp/ws-security
 */
final class TransformationParameters extends AbstractTransformationParametersType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
