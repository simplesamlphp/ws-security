<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;

/**
 * An AbstractAttributeExtensibleURI element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractAttributeExtensibleURI extends AbstractAttributeExtensibleString
{
    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\XML\Exception\SchemaViolationException on failure
     * @return void
     */
    #[\Override]
    protected function validateContent(string $content): void
    {
        Assert::validURI($content, SchemaViolationException::class);
    }
}
