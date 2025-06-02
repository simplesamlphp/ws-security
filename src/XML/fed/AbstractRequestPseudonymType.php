<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{ExtendableAttributesTrait, ExtendableElementTrait};
use SimpleSAML\XML\Type\BooleanValue;
use SimpleSAML\XML\XsNamespace as NS;

use function var_export;

/**
 * Class defining the RequestPseudonymType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRequestPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractRequestPseudonymType constructor
     *
     * @param \SimpleSAML\XML\Type\BooleanValue|null $SingleUse
     * @param \SimpleSAML\XML\Type\BooleanValue|null $Lookup
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?BooleanValue $SingleUse = null,
        protected ?BooleanValue $Lookup = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getSingleUse(): ?BooleanValue
    {
        return $this->SingleUse;
    }


    /**
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getLookup(): ?BooleanValue
    {
        return $this->Lookup;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getSingleUse())
            && empty($this->getLookup())
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

        return new static(
            self::getOptionalAttribute($xml, 'SingleUse', BooleanValue::class, null),
            self::getOptionalAttribute($xml, 'Lookup', BooleanValue::class, null),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this AbstractRequestPseudonymType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $singleUse = $this->getSingleUse();
        if ($singleUse !== null) {
            $e->setAttribute('SingleUse', var_export($singleUse->toBoolean(), true));
        }

        $lookup = $this->getLookup();
        if ($lookup !== null) {
            $e->setAttribute('Lookup', var_export($lookup->toBoolean(), true));
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
