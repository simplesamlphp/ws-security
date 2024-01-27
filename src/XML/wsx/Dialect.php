<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use SimpleSAML\XML\URIElementTrait;

/**
 * An Dialect element
 *
 * @package tvdijen/ws-security
 */
final class Dialect extends AbstractWsxElement
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
