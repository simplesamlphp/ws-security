<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\URIElementTrait;

/**
 * @package tvdijen/ws-security
 */
final class SoapAction extends AbstractWsaElement
{
    use URIElementTrait;


    /**
     * Initialize a wsa:SoapAction
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setContent($value);
    }


    /**
     * Convert XML into a wsa:SoapAction
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'SoapAction', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, SoapAction::NS, InvalidDOMElementException::class);

        return new static($xml->textContent);
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
        $e->textContent = $this->getContent();

        return $e;
    }
}
