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
 * Abstract class defining the PasswordString type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractPasswordString extends AbstractAttributedString
{
    /**
     * AbstractPasswordString constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\XMLSchema\Type\IDValue|null $Id
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Type
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        #[\SensitiveParameter]
        StringValue $content,
        ?IDValue $Id = null,
        protected ?AnyURIValue $Type = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($content, $Id, $namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getType(): ?AnyURIValue
    {
        return $this->Type;
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
            $Id,
            self::getOptionalAttribute($xml, 'Type', AnyURIValue::class, null),
            $nsAttributes,
        );
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getType() !== null) {
            $e->setAttribute('Type', $this->getType()->getValue());
        }

        return $e;
    }
}
