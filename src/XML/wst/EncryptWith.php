<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * An EncryptWith element
 *
 * @package tvdijen/ws-security
 */
final class EncryptWith extends AbstractWstElement
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
