<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A TokenType element
 *
 * @package tvdijen/ws-security
 */
final class TokenType extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
