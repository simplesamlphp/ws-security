<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;

use function array_filter;
use function array_values;

/**
 * @package tvdijen/ws-security
 */
final class InteractiveChallengeResponse extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = C::XS_ANY_NS_ANY;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * Initialize a wst:InteractiveChallengeResponse
     *
     * @param \SimpleSAML\XML\ElementInterface[] $elements
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(array $elements, array $namespacedAttributes = [])
    {
        $this->setElements($elements);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst\TextChallengeResponse[]
     */
    public function getTextChallengeResponse(): array
    {
        return array_values(array_filter($this->elements, function ($element) {
            return $element instanceof TextChallengeResponse;
        }));
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst\ChoiceChallengeResponse[]
     */
    public function getChoiceChallengeResponse(): array
    {
        return array_values(array_filter($this->elements, function ($element) {
            return $element instanceof ChoiceChallengeResponse;
        }));
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst\ContextData[]
     */
    public function getContextData(): array
    {
        return array_values(array_filter($this->elements, function ($element) {
            return $element instanceof ContextData;
        }));
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getElements()) && empty($this->getAttributesNS());
    }


    /**
     * Convert XML into a wst:InteractiveChallengeResponse
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'InteractiveChallengeResponse', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, InteractiveChallengeResponse::NS, InvalidDOMElementException::class);

        $children = [];
        foreach ($xml->childNodes as $node) {
            if (!($node instanceof DOMElement)) {
                continue;
            } elseif ($node->namespaceURI === C::NS_TRUST) {
                $children[] = match ($node->localName) {
                    'TextChallengeResponse' => TextChallengeResponse::fromXML($node),
                    'ChoiceChallengeResponse' => ChoiceChallengeResponse::fromXML($node),
                    'ContextData' => ContextData::fromXML($node),
                    default => new Chunk($node),
                };
            } else {
                $children[] = new Chunk($node);
            }
        }

        return new static($children, self::getAttributesNSFromXML($xml));
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $elt */
        foreach ($this->getElements() as $elt) {
            if (!$elt->isEmptyElement()) {
                $elt->toXML($e);
            }
        }

        return $e;
    }
}
