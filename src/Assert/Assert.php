<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\Assert;

use SimpleSAML\XMLSecurity\Assert\Assert as BaseAssert;

/**
 * @package simplesamlphp/ws-security
 *
 * @method static void validWSUDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void allWSUDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void nullOrValueWSUDateTime(mixed $value, string $message = '', string $exception = '')
 */
class Assert extends BaseAssert
{
    use WSUDateTimeTrait;
}
