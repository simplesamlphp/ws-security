<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * @package simplesamlphp/ws-security
 */
trait UsageTrait
{
    /** @var \SimpleSAML\XMLSchema\Type\AnyURIValue|null */
    protected ?string $usage;


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getUsage(): ?AnyURIValue
    {
        return $this->usage;
    }


    /**
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $usage|null
     */
    private function setUsage(?AnyURIValue $usage): void
    {
        $this->usage = $usage;
    }
}
