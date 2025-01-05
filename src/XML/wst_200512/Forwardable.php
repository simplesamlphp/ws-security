<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\BooleanElementTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A Forwardable element
 *
 * @package simplesamlphp/ws-security
 */
final class Forwardable extends AbstractWstElement implements SchemaValidatableElementInterface
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
