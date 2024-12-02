<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\URIElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class representing WS-addressing RelationshipType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available and the
 * class will generate an element with the same name as the extending class (e.g. \SimpleSAML\WSSecurity\wsa\Address).
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRelationshipType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use URIElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractRelationshipType constructor.
     *
     * @param string $value The localized string.
     * @param string|null $relationshipType
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        string $value,
        protected ?string $relationshipType = null,
        array $namespacedAttributes = [],
    ) {
        Assert::validQName($relationshipType);

        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Retrieve the value of the relationshipType property
     */
    public function getRelationshipType(): ?string
    {
        return $this->relationshipType;
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
            self::getOptionalAttribute($xml, 'RelationshipType', null),
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
        $e->textContent = $this->getContent();

        if ($this->getRelationshipType() !== null) {
            $e->setAttribute('RelationshipType', $this->getRelationshipType());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
