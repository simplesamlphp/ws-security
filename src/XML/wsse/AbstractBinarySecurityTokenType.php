<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the BinarySecurityTokenType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractBinarySecurityTokenType extends AbstractEncodedString
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractBinarySecurityTokenType constructor
     *
     * @param string $content
     * @param string|null $valueType
     * @param string|null $Id
     * @param string|null $EncodingType
     * @param array $namespacedAttributes
     */
    final public function __construct(
        string $content,
        protected ?string $valueType = null,
        ?string $Id = null,
        ?string $EncodingType = null,
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidURI($valueType, SchemaViolationException::class);

        parent::__construct($content, $Id, $EncodingType, $namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getValueType(): ?string
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
            $xml->textContent,
            self::getOptionalAttribute($xml, 'ValueType', null),
            $Id,
            self::getOptionalAttribute($xml, 'EncodingType', null),
            $nsAttributes,
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
        $e = parent::toXML($parent);

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType());
        }

        return $e;
    }
}
