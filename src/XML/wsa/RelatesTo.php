<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function is_null;

/**
 * Class representing a wsa:RelatesTo element.
 *
 * @package tvdijen/ws-security
 */
final class RelatesTo extends AbstractWsaElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * Initialize a wsa:RelatesTo
     *
     * @param string|null $RelationshipType
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ?string $RelationshipType = 'http://www.w3.org/2005/08/addressing/reply',
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidURI($RelationshipType, SchemaViolationException::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the RelationshipType property.
     *
     * @return string|null
     */
    public function getRelationshipType(): ?string
    {
        return $this->RelationshipType;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return is_null($this->RelationshipType) && empty($this->namespacedAttributes);
    }


    /*
     * Convert XML into an RelatesTo element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'RelatesTo', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, RelatesTo::NS, InvalidDOMElementException::class);

        return new static(
            self::getOptionalAttribute($xml, 'RelationshipType', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this RelatesTo to XML.
     *
     * @param \DOMElement|null $parent The element we should add this RelatesTo to.
     * @return \DOMElement This Header-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getRelationshipType() !== null) {
            $e->setAttribute('RelationshipType', $this->getRelationshipType());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
