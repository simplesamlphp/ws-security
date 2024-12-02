<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the ReferenceType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractReferenceType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractReferenceType constructor
     *
     * @param string|null $URI
     * @param string|null $valueType
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?string $URI = null,
        protected ?string $valueType = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidURI($URI, SchemaViolationException::class);
        Assert::nullOrValidURI($valueType, SchemaViolationException::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getValueType(): ?string
    {
        return $this->valueType;
    }


    /**
     * @return string|null
     */
    public function getURI(): ?string
    {
        return $this->URI;
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

        return new static(
            self::getOptionalAttribute($xml, 'URI', null),
            self::getOptionalAttribute($xml, 'ValueType', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getURI() !== null) {
            $e->setAttribute('URI', $this->getURI());
        }

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
