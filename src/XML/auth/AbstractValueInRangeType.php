<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

use function array_pop;

/**
 * Class defining the ValueInRangeType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractValueInRangeType extends AbstractAuthElement
{
    /**
     * AbstractValueInRangeType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\auth\ValueUpperBound $valueUpperBound
     * @param \SimpleSAML\WSSecurity\XML\auth\ValueLowerBound $valueLowerBound
     */
    final public function __construct(
        protected ValueUpperBound $valueUpperBound,
        protected ValueLowerBound $valueLowerBound
    ) {
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $valueUpperBound = ValueUpperBound::getChildrenOfClass($xml);
        $valueLowerBound = ValueLowerBound::getChildrenOfClass($xml);

        return new static(
            array_pop($valueUpperBound),
            array_pop($valueLowerBound),
        );
    }


    /**
     * Get the value of the $valueUpperBound property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\ValueUpperBound
     */
    public function getValueUpperBound(): ValueUpperBound
    {
        return $this->valueUpperBound;
    }


    /**
     * Get the value of the $valueLowerBound property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\ValueLowerBound
     */
    public function getValueLowerBound(): ValueLowerBound
    {
        return $this->valueLowerBound;
    }


    /**
     * Add this ValueInRangeType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getValueUpperBound()->toXML($e);
        $this->getValueLowerBound()->toXML($e);

        return $e;
    }
}
