<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A RequestTypeOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractRequestTypeOpenEnum extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\RequestTypeEnum|string $content
     */
    public function __construct(RequestTypeEnum|string $content)
    {
        if ($content instanceof RequestTypeEnum) {
            $content = $content->value;
        }

        $this->setContent($content);
    }
}
