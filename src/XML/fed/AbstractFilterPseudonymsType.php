<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A FilterPseudonymsType
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractFilterPseudonymsType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * FilterPseudonymsType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis|null $pseudonymBasis
     * @param \SimpleSAML\WSSecurity\XML\fed\RelativeTo|null $relativeTo
     * @param \SimpleSAML\XML\SerializableElementInterface[] $childeren
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected ?PseudonymBasis $pseudonymBasis = null,
        protected ?RelativeTo $relativeTo = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the pseudonymBasis-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis|null
     */
    public function getPseudonymBasis(): ?PseudonymBasis
    {
        return $this->pseudonymBasis;
    }


    /**
     * Collect the value of the relativeTo-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\RelativeTo|null
     */
    public function getRelativeTo(): ?RelativeTo
    {
        return $this->relativeTo;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getPseudonymBasis())
            && empty($this->getRelativeTo())
            && empty($this->getElements())
            && empty($this->getAttributesNS());
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

        $pseudonymBasis = PseudonymBasis::getChildrenOfClass($xml);
        Assert::maxCount($pseudonymBasis, 1, TooManyElementsException::class);

        $relativeTo = RelativeTo::getChildrenOfClass($xml);
        Assert::maxCount($relativeTo, 1, TooManyElementsException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            array_pop($pseudonymBasis),
            array_pop($relativeTo),
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this FilterPseudonymsType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getPseudonymBasis()?->toXML($e);
        $this->getRelativeTo()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
