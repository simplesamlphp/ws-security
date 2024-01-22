<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A ComputedKeyOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractComputedKeyOpenEnum extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\ComputedKeyEnum|string $content
     */
    public function __construct(ComputedKeyEnum|string $content)
    {
        if ($content instanceof ComputedKeyEnum) {
            $content = $content->value;
        }

        $this->setContent($content);
    }
}
