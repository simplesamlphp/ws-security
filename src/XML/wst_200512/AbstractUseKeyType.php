<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

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
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Sig
     */
    final public function __construct(
        ?SerializableElementInterface $child = null,
        protected ?AnyURIValue $Sig = null,
    ) {
        if ($child !== null) {
            $this->setElements([$child]);
        }
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getSig(): ?AnyURIValue
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
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
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
            self::getOptionalAttribute($xml, 'Sig', AnyURIValue::class, null),
        );
    }


    /**
     * Add this UseKeyType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getSig() !== null) {
            $e->setAttribute('Sig', $this->getSig()->getValue());
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
