<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue;

/**
 * Trait grouping common functionality for elements that can hold a PolicyURIs attribute.
 *
 * @package simplesamlphp/ws-security
 * @phpstan-ignore trait.unused
 */
trait PolicyURIsTrait
{
    /**
     * The PolicyURIs.
     *
     * @var \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue
     */
    protected AnyURIListValue $PolicyURIs;


    /**
     * Collect the value of the PolicyURIs-property
     *
     * @return \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue
     */
    public function getPolicyURIs(): AnyURIListValue
    {
        return $this->PolicyURIs;
    }


    /**
     * Set the value of the PolicyURIs-property
     *
     * @param \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue $PolicyURIs
     */
    protected function setPolicyURIs(AnyURIListValue $PolicyURIs): void
    {
        $this->PolicyURIs = $PolicyURIs;
    }
}
