<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\BooleanElementTrait;

/**
 * A Delegatable element
 *
 * @package simplesamlphp/ws-security
 */
final class Delegatable extends AbstractWstElement
{
    use BooleanElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
