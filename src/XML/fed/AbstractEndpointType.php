<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\wsa_200508\EndpointReference;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException};

/**
 * An EndpointType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractEndpointType extends AbstractFedElement
{
    /**
     * ReferenceType constructor.
     *
     * @param array<\SimpleSAML\WSSecurity\XML\wsa_200508\EndpointReference> $endpointReference
     */
    final public function __construct(
        protected array $endpointReference,
    ) {
        Assert::minCount($endpointReference, 1, MissingElementException::class);
        Assert::allIsInstanceOf($endpointReference, EndpointReference::class);
    }


    /**
     * @return array<\SimpleSAML\WSSecurity\XML\wsa_200508\EndpointReference>
     */
    public function getEndpointReference(): array
    {
        return $this->endpointReference;
    }


    /*
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

        return new static(
            EndpointReference::getChildrenOfClass($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getEndpointReference() as $endpointReference) {
            $endpointReference->toXML($e);
        }

        return $e;
    }
}
