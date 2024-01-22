<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A BinaryExchangeType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractBinaryExchangeType extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use StringElementTrait;

    /** @var string|\SimpleSAML\XML\XsNamespace */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * @param string $content
     * @param string $valueType
     * @param string $encodingType
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        string $content,
        protected string $valueType,
        protected string $encodingType,
        array $namespacedAttributes
    ) {
        Assert::validURI($valueType, SchemaViolationException::class);
        Assert::validURI($encodingType, SchemaViolationException::class);

        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the valueType property.
     *
     * @return string
     */
    public function getValueType(): string
    {
        return $this->valueType;
    }


    /**
     * Get the valueType property.
     *
     * @return string
     */
    public function getEncodingType(): string
    {
        return $this->encodingType;
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            $xml->textContent,
            self::getAttribute($xml, 'ValueType'),
            self::getAttribute($xml, 'EncodingType'),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        $e->setAttribute('ValueType', $this->getValueType());
        $e->setAttribute('EncodingType', $this->getEncodingType());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
