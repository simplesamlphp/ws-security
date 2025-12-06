<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue;

/**
 * Trait grouping common functionality for elements that can hold IncludeToken attributes.
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-ignore trait.unused
 */
trait IncludeTokenTypeTrait
{
    /**
     * The included token.
     *
     * @var \SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue|null
     */
    protected ?IncludeTokenValue $includeToken;


    /**
     * Collect the value of the includeToken-property
     *
     * @return \SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue|null
     */
    public function getIncludeToken(): ?IncludeTokenValue
    {
        return $this->includeToken;
    }


    /**
     * Set the value of the includeToken-property
     *
     * @param \SimpleSAML\WSSecurity\XML\sp_200702\Type\IncludeTokenValue|null $includeToken
     */
    protected function setIncludeToken(?IncludeTokenValue $includeToken): void
    {
        $this->includeToken = $includeToken;
    }
}
