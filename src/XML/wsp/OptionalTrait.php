<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

/**
 * Trait grouping common functionality for elements that can hold an Optional attribute.
 *
 * @package tvdijen/ws-security
 */
trait OptionalTrait
{
    /**
     * The Optional.
     *
     * @var bool
     */
    protected bool $Optional;


    /**
     * Collect the value of the Optional-property
     *
     * @return bool
     */
    public function getOptional(): bool
    {
        return $this->Optional;
    }


    /**
     * Set the value of the Optional-property
     *
     * @param bool $Optional
     */
    protected function setOptional(?bool $Optional): void
    {
        $this->Optional = $Optional ?? false;
    }
}
