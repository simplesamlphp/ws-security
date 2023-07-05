<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

use function array_pop;

/**
 * @package tvdijen/ws-security
 */
final class ChoiceChallenge extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ReferenceIdentifierTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;

    /** @var string|null */
    protected ?string $label;

    /** @var bool */
    protected bool $exactlyOne;

    /** @var \SimpleSAML\WSSecurity\XML\wst\Choice|null */
    protected ?Choice $choice;


    /**
     * Initialize a wst:ChoiceChallenge
     *
     * @param string $refId
     * @param bool $exactlyOne
     * @param string|null $label
     * @param \SimpleSAML\WSSecurity\XML\wst\Choice|null $choice
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        string $refId,
        bool $exactlyOne,
        ?string $label = null,
        ?Choice $choice = null,
        array $namespacedAttributes = []
    ) {
        $this->setRefId($refId);
        $this->setExactlyOne($exactlyOne);
        $this->setLabel($label);
        $this->setChoice($choice);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the exactlyOne property.
     *
     * @return bool
     */
    public function getExactlyOne(): bool
    {
        return $this->exactlyOne;
    }


    /**
     * Set the value of the exactlyOne property.
     *
     * @param bool $exactlyOne
     */
    protected function setExactlyOne(bool $exactlyOne): void
    {
        $this->exactlyOne = $exactlyOne;
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
     * Set the value of the label property.
     *
     * @param string|null $label
     */
    protected function setLabel(?string $label): void
    {
        $this->label = $label;
    }


    /**
     * Collect the value of the choice property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wst\Choice|null
     */
    public function getChoice(): ?Choice
    {
        return $this->choice;
    }


    /**
     * Set the value of the choice property.
     *
     * @param \SimpleSAML\WSSecurity\XML\wst\Choice|null $choice
     */
    protected function setChoice(?Choice $choice): void
    {
        $this->choice = $choice;
    }


    /**
     * Convert XML into a wst:ChoiceChallenge
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'ChoiceChallenge', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ChoiceChallenge::NS, InvalidDOMElementException::class);

        $refId = self::getAttribute($xml, 'RefID');
        $exactlyOne = self::getBooleanAttribute($xml, 'ExactlyOne');
        $label = self::getOptionalAttribute($xml, 'Label', null);

        $choice = Choice::getChildrenOfClass($xml);
        Assert::maxCount($choice, 1, TooManyElementsException::class);

        return new static($refId, $exactlyOne, $label, array_pop($choice), self::getAttributesNSFromXML($xml));
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
        $e->setAttribute('ExactlyOne', strval($this->getExactlyOne()));

        $label = $this->getLabel();
        if ($label !== null) {
            $e->setAttribute('Label', $label);
        }

        $this->getChoice()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
