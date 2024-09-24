<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\Base64ElementTrait;

/**
 * A CombinedHash element
 *
 * @package simplesamlphp/ws-security
 */
final class CombinedHash extends AbstractWstElement
{
    use Base64ElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
