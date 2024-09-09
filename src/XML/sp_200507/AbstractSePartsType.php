<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;
use function sprintf;

/**
 * Class representing WS security policy AbstractSePartsType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSePartsType extends AbstractSpElement
{
    use ExtendableElementTrait;
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * AbstractSePartsType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\Body|null $body
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\Header[] $header
     * @param \SimpleSAML\XML\Chunk[] $details
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected ?Body $body = null,
        protected array $header = [],
        array $details = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($details);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the Body
     *
     * @return \SimpleSAML\WSSecurity\XML\sp_200507\Body|null
     */
    public function getBody(): ?Body
    {
        return $this->body;
    }


    /**
     * Collect the Header
     *
     * @return \SimpleSAML\WSSecurity\XML\sp_200507\Header[]
     */
    public function getHeader(): array
    {
        return $this->header;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getElements())
            && empty($this->getBody())
            && empty($this->getHeader())
            && empty($this->getAttributesNS());
    }


    /**
     * Initialize an SePartsType.
     *
     * Note: this method cannot be used when extending this class, if the constructor has a different signature.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        $qualifiedName = static::getClassName(static::class);
        Assert::eq(
            $xml->localName,
            $qualifiedName,
            sprintf('Unexpected name for Empty: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        $body = Body::getChildrenOfClass($xml);

        $header = Header::getChildrenOfClass($xml);
        Assert::maxCount($header, 1, TooManyElementsException::class);

        $details = [];
        foreach ($xml->childNodes as $detail) {
            if (!($detail instanceof DOMElement)) {
                continue;
            } elseif ($detail->namespaceURI === static::NS) {
                continue;
            }

            $details[] = new Chunk($detail);
        }

        return new static(
            array_pop($body),
            $header,
            $details,
            self::getAttributesNSFromXML($xml),
        );
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

        if ($this->getBody() !== null) {
            $this->getBody()->toXML($e);
        }

        foreach ($this->getHeader() as $header) {
            $header->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $elt */
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
