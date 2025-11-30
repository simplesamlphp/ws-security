<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * A BinaryExchangeType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractBinaryExchangeType extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = StringValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $valueType
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $encodingType
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        StringValue $content,
        protected AnyURIValue $valueType,
        protected AnyURIValue $encodingType,
        array $namespacedAttributes,
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the valueType property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getValueType(): AnyURIValue
    {
        return $this->valueType;
    }


    /**
     * Get the valueType property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getEncodingType(): AnyURIValue
    {
        return $this->encodingType;
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            StringValue::fromString($xml->textContent),
            self::getAttribute($xml, 'ValueType', AnyURIValue::class),
            self::getAttribute($xml, 'EncodingType', AnyURIValue::class),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        $e->setAttribute('ValueType', $this->getValueType()->getValue());
        $e->setAttribute('EncodingType', $this->getEncodingType()->getValue());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
