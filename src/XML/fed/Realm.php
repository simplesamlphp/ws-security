<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\URIElementTrait;

/**
 * A Realm element
 *
 * @package tvdijen/ws-security
 */
final class Realm extends AbstractFedElement
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
