<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the ParticipantsType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractParticipantsType extends AbstractWstElement
{
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractParticipantsType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wst_200512\Primary|null $primary
     * @param array<\SimpleSAML\WSSecurity\XML\wst_200512\Participant> $participant
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     */
    final public function __construct(
        protected ?Primary $primary = null,
        protected array $participant = [],
        array $children = [],
    ) {
        $this->setElements($children);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst_200512\Primary|null
     */
    public function getPrimary(): ?Primary
    {
        return $this->primary;
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst_200512\Participant[]
     */
    public function getParticipant(): array
    {
        return $this->participant;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getPrimary())
            && empty($this->getParticipant())
            && empty($this->getElements());
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

        $primary = Primary::getChildrenOfClass($xml);
        Assert::maxCount($primary, 1, TooManyElementsException::class);

        return new static(
            array_pop($primary),
            Participant::getChildrenOfClass($xml),
            self::getChildElementsFromXML($xml),
        );
    }


    /**
     * Add this ParticipantsType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getPrimary()?->toXML($e);

        foreach ($this->getParticipant() as $p) {
            $p->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
