<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use DOMElement;
use SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;

use function array_pop;

/**
 * Class defining the RequestedReferenceType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRequestedReferenceType extends AbstractWstElement
{
    /**
     * AbstractRequestedReferenceType constructor
     *
     * @param \SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference $securityTokenReference
     */
    final public function __construct(
        protected SecurityTokenReference $securityTokenReference,
    ) {
    }


    /**
     * Collect the value of the securityTokenReference property.
     *
     * @return \SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference
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
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
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
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getSecurityTokenReference()->toXML($e);

        return $e;
    }
}
