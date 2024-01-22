<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\URIElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Abstract class defining the AttributedURI type
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractAttributedURI extends AbstractWsuElement
{
    use ExtendableAttributesTrait;
    use URIElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractAttributedURI constructor
     *
     * @param string $uri
     * @param string|null $Id
     * @param array $namespacedAttributes
     */
    final protected function __construct(
        string $uri,
        protected ?string $Id = null,
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setContent($uri);
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
        if ($xml->hasAttributeNS(static::NS, 'Id')) {
            $Id = $xml->getAttributeNS(static::NS, 'Id');
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
            $attributes[] = new XMLAttribute(static::NS, 'wsu', 'Id', $this->getId());
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
