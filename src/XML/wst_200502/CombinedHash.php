<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\XML\Base64ElementTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A CombinedHash element
 *
 * @package simplesamlphp/ws-security
 */
final class CombinedHash extends AbstractWstElement implements SchemaValidatableElementInterface
{
    use Base64ElementTrait;
    use SchemaValidatableElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}
