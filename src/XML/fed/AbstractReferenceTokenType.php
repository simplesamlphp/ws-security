<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException, SchemaViolationException};
use SimpleSAML\XML\{ExtendableAttributesTrait, ExtendableElementTrait};
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A ReferenceTokenType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractReferenceTokenType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * ReferenceTokenType constructor.
     *
     * @param array<\SimpleSAML\WSSecurity\XML\fed\ReferenceEPR> $referenceEPR
     * @param \SimpleSAML\WSSecurity\XML\fed\ReferenceDigest|null $referenceDigest
     * @param \SimpleSAML\WSSecurity\XML\fed\ReferenceType|null $referenceType
     * @param \SimpleSAML\WSSecurity\XML\fed\SerialNo|null $serialNo
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $referenceEPR = [],
        protected ?ReferenceDigest $referenceDigest = null,
        protected ?ReferenceType $referenceType = null,
        protected ?SerialNo $serialNo = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::minCount($referenceEPR, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $referenceEPR,
            ReferenceEPR::class,
            SchemaViolationException::class,
        );

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the referenceEPR-property
     *
     * @return array<\SimpleSAML\WSSecurity\XML\fed\ReferenceEPR>
     */
    public function getReferenceEPR(): array
    {
        return $this->referenceEPR;
    }


    /**
     * Collect the value of the referenceDigest-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ReferenceDigest|null
     */
    public function getReferenceDigest(): ?ReferenceDigest
    {
        return $this->referenceDigest;
    }


    /**
     * Collect the value of the referenceType-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ReferenceType|null
     */
    public function getReferenceType(): ?ReferenceType
    {
        return $this->referenceType;
    }


    /**
     * Collect the value of the serialNo-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\SerialNo|null
     */
    public function getSerialNo(): ?SerialNo
    {
        return $this->serialNo;
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

        $referenceEPR = ReferenceEPR::getChildrenOfClass($xml);
        $referenceDigest = ReferenceDigest::getChildrenOfClass($xml);
        $referenceType = ReferenceType::getChildrenOfClass($xml);
        $serialNo = SerialNo::getChildrenOfClass($xml);

        return new static(
            $referenceEPR,
            array_pop($referenceDigest),
            array_pop($referenceType),
            array_pop($serialNo),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ReferenceToken to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this ReferenceToken to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getReferenceEPR() as $repr) {
            $repr->toXML($e);
        }

        $this->getReferenceDigest()?->toXML($e);
        $this->getReferenceType()?->toXML($e);
        $this->getSerialNo()?->toXML($e);

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
