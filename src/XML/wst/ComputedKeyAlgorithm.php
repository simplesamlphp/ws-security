<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A ComputedKeyAlgorithm element
 *
 * @package tvdijen/ws-security
 */
final class ComputedKeyAlgorithm extends AbstractWstElement
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
