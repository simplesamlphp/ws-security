<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\URIElementTrait;

/**
 * An IssuerName element
 *
 * @package simplesamlphp/ws-security
 */
final class IssuerName extends AbstractSpElement
{
    use URIElementTrait;


    /**
     * Initialize an IssuerName.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
