<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A PseudonymType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'PseudonymBasis'],
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'RelativeTo'],
    ];


    /**
     * PseudonymType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis $pseudonymBasis
     * @param \SimpleSAML\WSSecurity\XML\fed\RelativeTo $relativeTo
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected PseudonymBasis $pseudonymBasis,
        protected RelativeTo $relativeTo,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the pseudonymBasis-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis
     */
    public function getPseudonymBasis(): PseudonymBasis
    {
        return $this->pseudonymBasis;
    }


    /**
     * Collect the value of the relativeTo-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\RelativeTo
     */
    public function getRelativeTo(): RelativeTo
    {
        return $this->relativeTo;
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
        Assert::minCount($pseudonymBasis, 1, SchemaViolationException::class);
        Assert::maxCount($pseudonymBasis, 1, SchemaViolationException::class);

        $relativeTo = RelativeTo::getChildrenOfClass($xml);
        Assert::minCount($relativeTo, 1, SchemaViolationException::class);
        Assert::maxCount($relativeTo, 1, SchemaViolationException::class);

        return new static(
            array_pop($pseudonymBasis),
            array_pop($relativeTo),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this PseudonymType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getPseudonymBasis()->toXML($e);
        $this->getRelativeTo()->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
