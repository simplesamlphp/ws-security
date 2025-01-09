<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * @package simplesamlphp/ws-security
 */
trait ReferenceIdentifierTrait
{
    /** @var string */
    protected string $refId;


    /**
     * @return string
     */
    public function getRefId(): string
    {
        return $this->refId;
    }


    /**
     * @param string $refId
     */
    private function setRefId(string $refId): void
    {
        Assert::validURI($refId, SchemaViolationException::class);
        $this->refId = $refId;
    }
}
