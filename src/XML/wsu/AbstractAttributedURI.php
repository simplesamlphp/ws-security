<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class defining the AttributedURI type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAttributedURI extends AbstractWsuElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractAttributedURI constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $uri
     * @param \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final protected function __construct(
        AnyURIValue $uri,
        protected ?IDValue $Id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setContent($uri);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->Id;
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

        $Id = null;
        if ($xml->hasAttributeNS(static::NS, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(static::NS, 'Id'));
        }

        return new static(AnyURIValue::fromString($xml->textContent), $Id, self::getAttributesNSFromXML($xml));
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    final public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $this->getId()->toAttribute()->toXML($e);
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
