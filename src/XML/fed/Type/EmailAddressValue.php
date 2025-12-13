<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed\Type;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XMLSchema\Type\StringValue;

use function preg_replace;

/**
 * @package simplesaml/ws-security
 */
class EmailAddressValue extends StringValue
{
    /**
     * Sanitize the content of the element.
     *
     * @param string $value  The unsanitized value
     * @throws \Exception on failure
     * @return string
     */
    protected function sanitizeValue(string $value): string
    {
        $normalizedValue = static::collapseWhitespace(static::normalizeWhitespace($value));

        // Remove prefixed schema and forward slashes
        return preg_replace('/^(mailto:)+/i', '', $normalizedValue);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $value  The value to go in the XML textContent
     * @throws \Exception on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        Assert::email($this->sanitizeValue($value));
    }
}
