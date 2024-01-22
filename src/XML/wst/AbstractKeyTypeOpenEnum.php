<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A KeyTypeOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractKeyTypeOpenEnum extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\KeyTypeEnum|string $content
     */
    public function __construct(KeyTypeEnum|string $content)
    {
        if ($content instanceof KeyTypeEnum) {
            $content = $content->value;
        }

        $this->setContent($content);
    }
}
