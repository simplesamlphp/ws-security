<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;

/**
 * Abstract class defining the AttributedString type
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractAttributedString extends AbstractWsseElement
{
    use ExtendableAttributesTrait;
    use StringElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * AbstractAttributedString constructor
     *
     * @param string $content
     * @param string|null $Id
     * @param array $namespacedAttributes
     */
    public function __construct(
        string $content,
        protected ?string $Id = null,
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setContent($content);
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

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = $xml->getAttributeNS(C::NS_SEC_UTIL, 'Id');
        }

        return new static($xml->textContent, $Id, self::getAttributesNSFromXML($xml));
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    final public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $attributes[] = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', $this->getId());
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
