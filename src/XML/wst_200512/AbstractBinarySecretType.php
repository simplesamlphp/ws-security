<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * A BinarySecertType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractBinarySecretType extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = Base64BinaryValue::class;

    /** @var string|\SimpleSAML\XML\XsNamespace */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * @param \SimpleSAML\XMLSchema\Type\Base64BinaryValue $content
     * @param \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue|null $Type
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        Base64BinaryValue $content,
        protected ?AnyURIListValue $Type = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the Type property.
     *
     * @return \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue|null
     */
    public function getType(): ?AnyURIListValue
    {
        return $this->Type;
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
            Base64BinaryValue::fromString($xml->textContent),
            self::getAttribute($xml, 'Type', AnyURIListValue::class),
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

        if ($this->getType() !== null) {
            $e->setAttribute('Type', $this->getType()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
