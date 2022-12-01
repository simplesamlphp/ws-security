<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

/**
 * @package tvdijen/ws-security
 */
final class ChoiceChallengeResponse extends AbstractWstElement
{
    use ReferenceIdentifierTrait;

    /** @var \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected[] */
    protected array $choiceSelected;


    /**
     * Initialize a wst:ChoiceChallengeResponse
     *
     * @param string $refId
     * @param \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected[] $choiceSelected
     */
    public function __construct(string $refId, array $choiceSelected)
    {
        $this->setRefId($refId);
        $this->setChoiceSelected($choiceSelected);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected[]
     */
    public function getChoiceSelected(): array
    {
        return $this->choiceSelected;
    }


    /**
     * @param \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected[] $choiceSelected
     */
    private function setChoiceSelected(array $choiceSelected): void
    {
        Assert::allIsInstanceOf($choiceSelected, ChoiceSelected::class, SchemaViolationException::class);
        $this->choiceSelected = $choiceSelected;
    }


    /**
     * Convert XML into a wst:ChoiceChallengeResponse
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'ChoiceChallengeResponse', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ChoiceChallengeResponse::NS, InvalidDOMElementException::class);

        /** @psalm-var string $refId */
        $refId = self::getAttribute($xml, 'RefId');

        return new static($refId, ChoiceSelected::getChildrenOfClass($xml));
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

        foreach ($this->getChoiceSelected() as $choiceSelected) {
            $choiceSelected->toXML($e);
        }

        return $e;
    }
}
