<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\Assert;

use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Exception\ProtocolViolationException;

/**
 * @package simplesamlphp/ws-security
 */
trait WSUDateTimeTrait
{
    /**
     * @param string $value
     * @param string $message
     */
    protected static function validWSUDateTime(string $value, string $message = ''): void
    {
        parent::validDateTime($value);

        try {
            parent::endsWith(
                $value,
                'Z',
                '%s is not a DateTime expressed in the UTC timezone using the \'Z\' timezone identifier.',
            );
        } catch (AssertionFailedException $e) {
            throw new ProtocolViolationException($e->getMessage());
        }
    }
}
