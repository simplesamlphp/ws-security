<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\StringElementTrait;

/**
 * A Challenge element
 *
 * @package simplesamlphp/ws-security
 */
final class Challenge extends AbstractWstElement
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
