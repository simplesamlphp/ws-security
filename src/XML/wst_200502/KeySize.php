<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\IntegerElementTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing WS-trust KeySize.
 *
 * @package simplesamlphp/ws-security
 */
final class KeySize extends AbstractWstElement implements SchemaValidatableElementInterface
{
    use IntegerElementTrait;
    use SchemaValidatableElementTrait;

    /**
     * KeySize constructor.
     *
     * @param string $value The long.
     */
    final public function __construct(string $value)
    {
        $this->setContent($value);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\XML\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        $content = intval($content);
        Assert::natural($content, SchemaViolationException::class);
        Assert::range($content, 0, 4294967295, SchemaViolationException::class);
    }
}
