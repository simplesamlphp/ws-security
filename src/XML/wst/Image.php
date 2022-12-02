<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Base64ElementTrait;

/**
 * @package tvdijen/ws-security
 */
final class Image extends AbstractWstElement
{
    use Base64ElementTrait;

    /**
     * Even though the schema doesn't mark this as required, the 2012 errata does.
     * @var string
      */
    protected string $mimeType;


    /**
     * Initialize a wst:Image
     *
     * @param string $content
     * @param string $mimeType
     */
    public function __construct(string $content, string $mimeType)
    {
        $this->setContent($content);
        $this->setMimeType($mimeType);
    }


    /**
     * Collect the value of the mimeType property.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }


    /**
     * Set the value of the mimeType property.
     *
     * @param string $mimeType
     */
    protected function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }


    /**
     * Convert XML into a wst:Image
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Image', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Image::NS, InvalidDOMElementException::class);

        /** @psalm-var string $mimeType */
        $mimeType = self::getAttribute($xml, 'MimeType');

        return new static($xml->textContent, $mimeType);
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
        $e->setAttribute('MimeType', $this->getMimeType());

        return $e;
    }
}
