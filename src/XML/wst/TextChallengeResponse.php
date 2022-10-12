<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

/**
 * @package tvdijen/ws-security
 */
final class TextChallengeResponse extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ReferenceIdentifierTrait;
    use StringElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = C::XS_ANY_NS_ANY;


    /**
     * Initialize a wst:TextChallengeResponse
     *
     * @param string $value
     * @param string $refId
     * @param \DOMAttr[] $namespacedAttributes
     */
    public function __construct(string $value, string $refId, array $namespacedAttributes = [])
    {
        $this->setContent($value);
        $this->setRefId($refId);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Convert XML into a wst:TextChallengeResponse
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'TextChallengeResponse', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, TextChallengeResponse::NS, InvalidDOMElementException::class);

        /** @psalm-var string $refId */
        $refId = self::getAttribute($xml, 'RefId');

        return new static($xml->textContent, $refId, self::getAttributesNSFromXML($xml));
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
        $e->setAttribute('RefId', $this->refId);
        $e->textContent = $this->getContent();

        foreach ($this->getAttributesNS() as $attr) {
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        return $e;
    }
}
