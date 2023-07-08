<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

use function array_pop;

/**
 * @package tvdijen/ws-security
 */
final class TextChallenge extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ReferenceIdentifierTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * Initialize a wst:TextChallenge
     *
     * @param string $refId
     * @param string|null $label
     * @param int|null $maxLen
     * @param bool|null $hideText
     * @param \SimpleSAML\WSSecurity\XML\wst\Image|null $image
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        string $refId,
        protected ?string $label = null,
        protected ?int $maxLen = null,
        protected ?bool $hideText = null,
        protected ?Image $image = null,
        array $namespacedAttributes = []
    ) {
        $this->setRefId($refId);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the maxLen property.
     *
     * @return int|null
     */
    public function getMaxLen(): ?int
    {
        return $this->maxLen;
    }


    /**
     * Collect the value of the hideText property.
     *
     * @return bool|null
     */
    public function getHideText(): ?bool
    {
        return $this->hideText;
    }


    /**
     * Collect the value of the label property.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }


    /**
     * Collect the value of the image property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wst\Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }


    /**
     * Convert XML into a wst:TextChallenge
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'TextChallenge', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, TextChallenge::NS, InvalidDOMElementException::class);

        $refId = self::getAttribute($xml, 'RefID');
        $label = self::getOptionalAttribute($xml, 'Label', null);
        $maxLen = self::getOptionalIntegerAttribute($xml, 'MaxLen', null);
        $hideText = self::getOptionalBooleanAttribute($xml, 'HideText', null);

        $image = Image::getChildrenOfClass($xml);
        Assert::maxCount($image, 1, TooManyElementsException::class);

        return new static($refId, $label, $maxLen, $hideText, array_pop($image), self::getAttributesNSFromXML($xml));
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

        if ($this->getLabel() !== null) {
            $e->setAttribute('Label', $this->getLabel());
        }

        $e->setAttribute('MaxLen', strval($this->getMaxLen()));
        $e->setAttribute('HideText', $this->getHideText() ? 'true' : 'false');

        $this->getImage()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
