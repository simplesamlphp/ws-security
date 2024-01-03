<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\StringElementTrait;

use function sprintf;

/**
 * A Realm element
 *
 * @package tvdijen/ws-security
 */
final class Realm extends AbstractFedElement
{
    use StringElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
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
        Assert::validURI($content, SchemaViolationException::class);
    }
}
