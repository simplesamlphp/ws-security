<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A StatusCodeOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractStatusCodeOpenEnum extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\StatusCodeEnum|string $content
     */
    public function __construct(StatusCodeEnum|string $content)
    {
        if ($content instanceof StatusCodeEnum) {
            $content = $content->value;
        }

        $this->setContent($content);
    }
}
