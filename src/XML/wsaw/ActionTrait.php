<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Trait adding methods to handle elements that define the action-attribute.
 *
 * @package simplesamlphp/ws-security
 */
trait ActionTrait
{
    /**
     * @var \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    protected ?AnyURIValue $action;


    /**
     * Collect the value of the action property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getAction(): ?AnyURIValue
    {
        return $this->action;
    }


    /**
     * Set the value of the action property.
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $action
     * @throws \SimpleSAML\XML\Exception\SchemViolationException
     */
    protected function setAction(?AnyURIValue $action): void
    {
        $this->action = $action;
    }
}
