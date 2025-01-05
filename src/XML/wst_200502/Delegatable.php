<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\BooleanElementTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Delegatable element
 *
 * @package simplesamlphp/ws-security
 */
final class Delegatable extends AbstractWstElement implements SchemaValidatableElementInterface
{
    use BooleanElementTrait;
    use SchemaValidatableElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
