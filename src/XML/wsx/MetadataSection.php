<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XML\XsNamespace as NS;

use function array_merge;
use function array_pop;

/**
 * Class defining the MetadataSection element
 *
 * @package simplesamlphp/ws-security
 */
final class MetadataSection extends AbstractWsxElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * MetadataSection constructor
     *
     * @param (\SimpleSAML\XML\SerializableElementInterface|
     *         \SimpleSAML\WSSecurity\XML\wsx\MetadataReference|
     *         \SimpleSAML\WSSecurity\XML\wsx\Location) $child
     * @param string $Dialect
     * @param string|null $Identifier
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected SerializableElementInterface|MetadataReference|Location $child,
        protected string $Dialect,
        protected ?string $Identifier = null,
        array $namespacedAttributes = [],
    ) {
        if (!($child instanceof MetadataReference) && !($child instanceof Location)) {
            Assert::notSame($child->toXML()->namespaceURI, static::NS);
        }
        Assert::validURI($Dialect);
        Assert::nullOrValidURI($Identifier);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the child property.
     *
     * @return (\SimpleSAML\XML\SerializableElementInterface|
     *         \SimpleSAML\WSSecurity\XML\wsx\MetadataReference|
     *         \SimpleSAML\WSSecurity\XML\wsx\Location)
     */
    public function getChild(): SerializableElementInterface|MetadataReference|Location
    {
        return $this->child;
    }


    /**
     * Get the Dialect property.
     *
     * @return string
     */
    public function getDialect(): string
    {
        return $this->Dialect;
    }


    /**
     * Get the Identifier property.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->Identifier;
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
        $metadataReference = MetadataReference::getChildrenOfClass($xml);
        $location = Location::getChildrenOfClass($xml);

        $children = array_merge($children, $metadataReference, $location);
        Assert::minCount($children, 1, MissingElementException::class);
        Assert::maxCount($children, 1, TooManyElementsException::class);

        return new static(
            array_pop($children),
            self::getAttribute($xml, 'Dialect'),
            self::getOptionalAttribute($xml, 'Identifier', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this MetadataSection to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this MetadataSection to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->setAttribute('Dialect', $this->getDialect());

        if ($this->getIdentifier() !== null) {
            $e->setAttribute('Identifier', $this->getIdentifier());
        }

        $this->getChild()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
