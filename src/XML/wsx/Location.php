<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use SimpleSAML\XML\URIElementTrait;

/**
 * An Location element
 *
 * @package tvdijen/ws-security
 */
final class Location extends AbstractWsxElement
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
