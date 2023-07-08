<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;

/**
 * Abstract class defining the EncodedString type
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractEncodedString extends AbstractAttributedString
{
    /**
     * AbstractEncodedString constructor
     *
     * @param string $content
     * @param string|null $Id
     * @param string|null $EncodingType
     * @param array $namespacedAttributes
     */
    public function __construct(
        string $content,
        ?string $Id = null,
        protected ?string $EncodingType = null,
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidURI($EncodingType);

        parent::__construct($content, $Id, $namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getEncodingType(): ?string
    {
        return $this->EncodingType;
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
            $Id,
            self::getOptionalAttribute($xml, 'EncodingType', null),
            $nsAttributes,
        );
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('EncodingType', $this->getEncodingType());

        return $e;
    }
}
