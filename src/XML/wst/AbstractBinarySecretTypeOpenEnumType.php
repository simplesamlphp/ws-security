<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use SimpleSAML\XML\URIElementTrait;

/**
 * A BinarySecretTypeOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractBinarySecretTypeOpenEnum extends AbstractWstElement
{
    use URIElementTrait;


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\BinarySecretTypeEnum|string $content
     */
    public function __construct(BinarySecretTypeEnum|string $content)
    {
        if ($content instanceof BinarySecretTypeEnum) {
            $content = $content->value;
        }

        $this->setContent($content);
    }
}
