<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\XML\wsse\SecurityTokenReference;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

use function array_pop;

/**
 * Class defining the RequestedReferenceType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractRequestedReferenceType extends AbstractWstElement
{
    /**
     * AbstractRequestedReferenceType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wsse\SecurityTokenReference $securityTokenReference
     */
    final public function __construct(
        protected SecurityTokenReference $securityTokenReference
    ) {
    }


    /**
     * Collect the value of the securityTokenReference property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsse\SecurityTokenReference
     */
    public function getSecurityTokenReference(): SecurityTokenReference
    {
        return $this->securityTokenReference;
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

        $securityTokenReference = SecurityTokenReference::getChildrenOfClass($xml);
        Assert::minCount($securityTokenReference, 1, MissingElementException::class);
        Assert::maxCount($securityTokenReference, 1, TooManyElementsException::class);

        return new static(array_pop($securityTokenReference));
    }


    /**
     * Add this RequestedReferenceType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getSecurityTokenReference()->toXML($e);

        return $e;
    }
}
