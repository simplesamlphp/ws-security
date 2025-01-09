<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Trait adding methods to handle elements that define the action-attribute.
 *
 * @package simplesamlphp/ws-security
 */
trait ActionTrait
{
    /**
     * @var string|null
     */
    protected ?string $action;


    /**
     * Collect the value of the action property.
     *
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }


    /**
     * Set the value of the action property.
     *
     * @param string|null $action
     * @throws \SimpleSAML\XML\Exception\SchemViolationException
     */
    protected function setAction(?string $action): void
    {
        Assert::nullOrValidURI($action, SchemaViolationException::class);
        $this->action = $action;
    }
}
