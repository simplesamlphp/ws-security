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

/**
 * Abstract class defining the EncodedString type
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractEncodedString extends AbstractAttributedString
{
    /**
     * AbstractEncodedString constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $EncodingType
     */
    public function __construct(
        StringValue $content,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
        protected ?AnyURIValue $EncodingType = null,
    ) {
        parent::__construct($content, $Id, $namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getEncodingType(): ?AnyURIValue
    {
        return $this->EncodingType;
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
            self::getOptionalAttribute($xml, 'EncodingType', AnyURIValue::class, null),
        );
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getEncodingType() !== null) {
            $e->setAttribute('EncodingType', $this->getEncodingType()->getValue());
        }

        return $e;
    }
}
