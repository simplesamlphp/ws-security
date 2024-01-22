<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\StringElementTrait;

/**
 * A Reason element
 *
 * @package tvdijen/ws-security
 */
final class Reason extends AbstractWstElement
{
    use StringElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
