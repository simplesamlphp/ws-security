<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use SimpleSAML\XML\StringElementTrait;

/**
 * Class representing WS-authorization Value.
 *
 * @package simplesamlphp/ws-security
 */
final class Value extends AbstractAuthElement
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
