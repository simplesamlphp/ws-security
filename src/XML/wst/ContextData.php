<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableElementTrait;

/**
 * @package tvdijen/ws-security
 */
final class ContextData extends AbstractWstElement
{
    use ExtendableElementTrait;
    use ReferenceIdentifierTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = C::XS_ANY_NS_ANY;


    /**
     * Initialize a wst:ContextData
     *
     * @param string $refId
     * @param \SimpleSAML\XML\ElementInterface[] $elements
     */
    public function __construct(string $refId, array $elements)
    {
        $this->setRefId($refId);
        $this->setElements($elements);
    }


    /**
     * Convert XML into a wst:ContextData
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'ContextData', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ContextData::NS, InvalidDOMElementException::class);

        $refId = self::getAttribute($xml, 'RefID');

        $children = [];
        foreach ($xml->childNodes as $node) {
            if ($node instanceof DOMElement) {
                $children[] = Chunk::fromXML($node);
            }
        }

        return new static($refId, $children);
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
        $e->setAttribute('RefID', $this->getRefId());

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $elt */
        foreach ($this->getElements() as $elt) {
            if (!$elt->isEmptyElement()) {
                $elt->toXML($e);
            }
        }

        return $e;
    }
}
