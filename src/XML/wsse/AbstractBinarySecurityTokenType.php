<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the BinarySecurityTokenType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractBinarySecurityTokenType extends AbstractEncodedString
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractBinarySecurityTokenType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $valueType
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $EncodingType
     */
    final public function __construct(
        StringValue $content,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
        protected ?AnyURIValue $valueType = null,
        ?AnyURIValue $EncodingType = null,
    ) {
        Assert::validBase64Binary($content->getValue());
        parent::__construct($content, $Id, $namespacedAttributes, $EncodingType);
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
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
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
                $Id = IDValue::fromString($attr->getAttrValue()->getValue());
                unset($nsAttributes[$i]);
                break;
            }
        }

        return new static(
            StringValue::fromString($xml->textContent),
            $Id,
            $nsAttributes,
            self::getOptionalAttribute($xml, 'ValueType', AnyURIValue::class, null),
            self::getOptionalAttribute($xml, 'EncodingType', AnyURIValue::class, null),
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
