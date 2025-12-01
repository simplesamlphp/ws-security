<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

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
     * @var \SimpleSAML\XMLSchema\Type\AnyURIValue[]
     */
    protected array $PolicyURIs;


    /**
     * Collect the value of the PolicyURIs-property
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue[]
     */
    public function getPolicyURIs(): array
    {
        return $this->PolicyURIs;
    }


    /**
     * Set the value of the PolicyURIs-property
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue[] $PolicyURIs
     */
    protected function setPolicyURIs(array $PolicyURIs): void
    {
        Assert::allIsInstanceOf($PolicyURIs, AnyURIValue::class, SchemaViolationException::class);
        $this->PolicyURIs = $PolicyURIs;
    }
}
