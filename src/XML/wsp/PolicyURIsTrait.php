<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\Assert\Assert;

/**
 * Trait grouping common functionality for elements that can hold a PolicyURIs attribute.
 *
 * @package simplesamlphp/ws-security
 */
trait PolicyURIsTrait
{
    /**
     * The PolicyURIs.
     *
     * @var string[]
     */
    protected array $PolicyURIs;


    /**
     * Collect the value of the PolicyURIs-property
     *
     * @return array
     */
    public function getPolicyURIs(): array
    {
        return $this->PolicyURIs;
    }


    /**
     * Set the value of the PolicyURIs-property
     *
     * @param array $PolicyURIs
     */
    protected function setPolicyURIs(array $PolicyURIs): void
    {
        Assert::allValidURI($PolicyURIs);
        $this->PolicyURIs = $PolicyURIs;
    }
}
