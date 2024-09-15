<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class representing a wsa:ReferenceProperties element.
 *
 * @package simplesamlphp/ws-security
 */
final class ReferenceProperties extends AbstractWsaElement
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsa:ReferenceProperties
     *
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     */
    public function __construct(array $children = [])
    {
        $this->setElements($children);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->elements);
    }


    /*
     * Convert XML into an ReferenceProperties element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'ReferenceProperties', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ReferenceProperties::NS, InvalidDOMElementException::class);

        return new static(
            self::getChildElementsFromXML($xml),
        );
    }


    /**
     * Convert this ReferenceProperties to XML.
     *
     * @param \DOMElement|null $parent The element we should add this ReferenceProperties to.
     * @return \DOMElement This Header-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
