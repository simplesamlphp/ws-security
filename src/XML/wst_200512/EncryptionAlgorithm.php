<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\URIElementTrait;

/**
 * A EncryptionAlgorithm element
 *
 * @package simplesamlphp/ws-security
 */
final class EncryptionAlgorithm extends AbstractWstElement
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
