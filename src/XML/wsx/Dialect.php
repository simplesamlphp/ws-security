<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\URIElementTrait;

/**
 * An Dialect element
 *
 * @package simplesamlphp/ws-security
 */
final class Dialect extends AbstractWsxElement implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
    use URIElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
