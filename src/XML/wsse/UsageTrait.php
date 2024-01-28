<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * @package simplesamlphp/ws-security
 */
trait UsageTrait
{
    /** @var string|null */
    protected ?string $usage;


    /**
     * @return string|null
     */
    public function getUsage(): ?string
    {
        return $this->usage;
    }


    /**
     * @param string $usage|null
     */
    private function setUsage(?string $usage): void
    {
        Assert::nullOrValidURI($usage, SchemaViolationException::class);
        $this->usage = $usage;
    }
}
