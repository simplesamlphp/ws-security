<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu\Type;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Exception\ProtocolViolationException;
use SimpleSAML\XMLSchema\Type\DateTimeValue as BaseDateTimeValue;

/**
 * @package simplesaml/saml2
 */
class DateTimeValue extends BaseDateTimeValue
{
    // Lowercase p as opposed to the base-class to covert the timestamp to UTC as demanded by the WSSecurity specifications
    public const DATETIME_FORMAT = 'Y-m-d\\TH:i:sp';


    /**
     * Validate the value.
     *
     * @param string $value
     * @return void
     */
    protected function validateValue(string $value): void
    {
        // Note: value must already be sanitized before validating
        Assert::validWSUDateTime($this->sanitizeValue($value), ProtocolViolationException::class);
    }
}
