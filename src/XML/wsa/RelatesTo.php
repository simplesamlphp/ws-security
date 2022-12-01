<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;

use function is_null;

/**
 * Class representing a wsa:RelatesTo element.
 *
 * @package tvdijen/ws-security
 */
final class RelatesTo extends AbstractWsaElement
{
    use ExtendableAttributesTrait;

    /** @param string|null $RelationshipType */
    protected ?string $RelationshipType;


    /**
     * Initialize a wsa:RelatesTo
     *
     * @param string|null $RelationshipType
     * @param \DOMAttr[] $namespacedAttributes
     */
    public function __construct(
        ?string $RelationshipType = 'http://www.w3.org/2005/08/addressing/reply',
        array $namespacedAttributes = []
    ) {
        $this->setRelationshipType($RelationshipType);
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
     * Set the value of the RelationshipType property.
     *
     * @param string|null $RelationshipType
     */
    protected function setRelationshipType(?string $RelationshipType): void
    {
        Assert::nullOrValidURI($RelationshipType, SchemaViolationException::class);
        $this->RelationshipType = $RelationshipType;
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
            self::getAttribute($xml, 'RelationshipType', null),
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
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        return $e;
    }
}
