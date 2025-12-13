<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML;

use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * @package simplesamlphp/ws-security
 *
 * @phpstan-ignore trait.unused
 */
trait ReferenceIdentifierTrait
{
    /** @var \SimpleSAML\XMLSchema\Type\AnyURIValue */
    protected AnyURIValue $refId;


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getRefId(): AnyURIValue
    {
        return $this->refId;
    }


    /**
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $refId
     */
    private function setRefId(AnyURIValue $refId): void
    {
        $this->refId = $refId;
    }
}
