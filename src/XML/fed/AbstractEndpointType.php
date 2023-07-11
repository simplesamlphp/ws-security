<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\XML\wsa\EndpointReference;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;

/**
 * An EndpointType
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractEndpointType extends AbstractFedElement
{
    /**
     * ReferenceType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\EndpointReference[] $endpointReference
     */
    final public function __construct(
        protected array $endpointReference,
    ) {
        Assert::minCount($endpointReference, 1, MissingElementException::class);
        Assert::allIsInstanceOf($endpointReference, EndpointReference::class);
    }


    /**
     * @return array
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
}
