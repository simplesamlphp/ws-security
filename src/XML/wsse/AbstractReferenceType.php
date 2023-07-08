<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;

/**
 * Class defining the ReferenceType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractReferenceType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;

    /**
     * AbstractReferenceType constructor
     *
     * @param string $URI
     * @param string $valueType
     * @param array $namespacedAttributes
     */
    public function __construct(
        protected string $URI,
        protected string $valueType,
        array $namespacedAttributes = []
    ) {
        Assert::validURI($URI, SchemaViolationException::class);
        Assert::validURI($valueType, SchemaViolationException::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string
     */
    public function getValueType(): string
    {
        return $this->valueType;
    }


    /**
     * @return string
     */
    public function getURI(): string
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
            self::getAttribute($xml, 'URI'),
            self::getAttribute($xml, 'ValueType'),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->setAttribute('URI', $this->getValueType());
        $e->setAttribute('ValueType', $this->getValueType());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
