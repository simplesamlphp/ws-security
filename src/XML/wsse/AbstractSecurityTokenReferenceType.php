<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_unshift;

/**
 * Class defining the SecurityTokenReferenceType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSecurityTokenReferenceType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use UsageTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id'],
    ];

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * AbstractSecurityReferenceType constructor
     *
     * @param string|null $Id
     * @param string|null $Usage
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?string $Id = null,
        ?string $Usage = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setUsage($Usage);
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->Id;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getId()) &&
            empty($this->getUsage()) &&
            empty($this->getElements()) &&
            empty($this->getAttributesNS());
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
            $xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id') ? $xml->getAttributeNS(C::NS_SEC_UTIL, 'Id') : null,
            $xml->hasAttributeNS(C::NS_SEC_EXT, 'Usage') ? $xml->getAttributeNS(C::NS_SEC_EXT, 'Usage') : null,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this SecurityTokenReferenceType token to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $idAttr = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', $this->getId());
            array_unshift($attributes, $idAttr);
        }

        if ($this->getUsage() !== null) {
            $UsageAttr = new XMLAttribute(C::NS_SEC_EXT, 'wsse', 'Usage', $this->getUsage());
            array_unshift($attributes, $UsageAttr);
        }

        foreach ($attributes as $attr) {
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
