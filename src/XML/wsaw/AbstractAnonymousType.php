<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use ValueError;

use function sprintf;

/**
 * Abstract class defining the Anonymous type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAnonymousType extends AbstractWsawElement
{
    /**
     * AbstractAnonymousType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wsaw\AnonymousEnum $value
     */
    public function __construct(
        protected AnonymousEnum $value,
    ) {
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsaw\AnonymousEnum
     */
    public function getValue(): AnonymousEnum
    {
        return $this->value;
    }


    /**
     * Convert this Anomymous to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this Anonymous.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getValue()->value;

        return $e;
    }
}
