<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\StringElementTrait;

/**
 * An IssuerName element
 *
 * @package tvdijen/ws-security
 */
final class IssuerName extends AbstractSpElement
{
    use StringElementTrait;


    /**
     * Initialize an IssuerName.
     *
     * @param string $content
     */
    public function __construct(
        string $content
    ) {
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
