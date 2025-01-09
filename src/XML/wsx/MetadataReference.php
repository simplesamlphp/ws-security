<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the MetadataReference element
 *
 * @package simplesamlphp/ws-security
 */
final class MetadataReference extends AbstractWsxElement implements SchemaValidatableElementInterface
{
    use ExtendableElementTrait;
    use SchemaValidatableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * MetadataReference constructor
     *
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     */
    final public function __construct(
        array $children = [],
    ) {
        Assert::minCount($children, 1, MissingElementException::class);
        $this->setElements($children);
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

        return new static(
            self::getChildElementsFromXML($xml),
        );
    }


    /**
     * Add this MetadataReference to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this MetadataReference to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
