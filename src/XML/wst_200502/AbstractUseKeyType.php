<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the UseKeyType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractUseKeyType extends AbstractWstElement
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * AbstractUseKeyType constructor
     *
     * @param \SimpleSAML\XML\SerializableElementInterface|null $child
     * @param string|null $Sig
     */
    final public function __construct(
        ?SerializableElementInterface $child = null,
        protected ?string $Sig = null,
    ) {
        Assert::nullOrValidURI($Sig, SchemaViolationException::class);

        if ($child !== null) {
            $this->setElements([$child]);
        }
    }


    /**
     * @return string|null
     */
    public function getSig(): ?string
    {
        return $this->Sig;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getSig())
            && empty($this->getElements());
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $children = self::getChildElementsFromXML($xml);
        Assert::maxCount($children, 1, TooManyElementsException::class);

        return new static(
            array_pop($children),
            self::getOptionalAttribute($xml, 'Sig', null),
        );
    }


    /**
     * Add this UseKeyType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getSig() !== null) {
            $e->setAttribute('Sig', $this->getSig());
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
