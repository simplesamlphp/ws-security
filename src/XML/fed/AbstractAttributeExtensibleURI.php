<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\Type\AnyURIValue;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * An AbstractAttributeExtensibleURI element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAttributeExtensibleURI extends AbstractFedElement
{
    use TypedTextContentTrait;
    use ExtendableAttributesTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * @param \SimpleSAML\XML\Type\AnyURIValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(AnyURIValue $content, array $namespacedAttributes = [])
    {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Create a class from XML
     *
     * @param \DOMElement $xml
     * @return static
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            AnyURIValue::fromString($xml->textContent),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Create XML from this class
     *
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
