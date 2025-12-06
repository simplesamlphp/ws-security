<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200508;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class representing a wsa:RelatesTo element.
 *
 * @package simplesamlphp/ws-security
 */
final class RelatesTo extends AbstractWsaElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * Initialize a wsa:RelatesTo
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $content
     * @param \SimpleSAML\XMLSchema\Type\QNameValue|null $RelationshipType
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        AnyURIValue $content,
        protected ?QNameValue $RelationshipType,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the RelationshipType property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue|null
     */
    public function getRelationshipType(): ?QNameValue
    {
        return $this->RelationshipType;
    }


    /*
     * Convert XML into an RelatesTo element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'RelatesTo', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, RelatesTo::NS, InvalidDOMElementException::class);

        return new static(
            AnyURIValue::fromString($xml->textContent),
            $xml->hasAttribute('RelationshipType')
                ? QNameValue::fromDocument($xml->getAttribute('RelationshipType'), $xml)
                : null,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this RelatesTo to XML.
     *
     * @param \DOMElement|null $parent The element we should add this RelatesTo to.
     * @return \DOMElement This Header-element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        if ($this->getRelationshipType() !== null) {
            $e->setAttribute('RelationshipType', $this->getRelationshipType()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
