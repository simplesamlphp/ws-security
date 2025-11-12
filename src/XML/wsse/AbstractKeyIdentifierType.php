<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\IDValue;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * Class defining the KeyIdentifierType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractKeyIdentifierType extends AbstractEncodedString
{
    /**
     * AbstractKeyIdentifierType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $valueType
     * @param \SimpleSAML\XMLSchema\Type\IDValue|null $Id
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $EncodingType
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        StringValue $content,
        protected ?AnyURIValue $valueType = null,
        ?IDValue $Id = null,
        ?AnyURIValue $EncodingType = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($content, $Id, $EncodingType, $namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getValueType(): ?AnyURIValue
    {
        return $this->valueType;
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

        $nsAttributes = self::getAttributesNSFromXML($xml);

        $Id = null;
        foreach ($nsAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === C::NS_SEC_UTIL && $attr->getAttrName() === 'Id') {
                $Id = $attr->getAttrValue();
                unset($nsAttributes[$i]);
                break;
            }
        }

        return new static(
            StringValue::fromString($xml->textContent),
            self::getOptionalAttribute($xml, 'ValueType', AnyURIValue::class, null),
            $Id,
            self::getOptionalAttribute($xml, 'EncodingType', AnyURIValue::class, null),
            $nsAttributes,
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType()->getValue());
        }

        return $e;
    }
}
