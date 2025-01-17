<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;

/**
 * Class defining the ContextItemType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractContextItemType extends AbstractAuthElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractContextItemType constructor
     *
     * @param string $Name
     * @param string|null $Scope
     * @param \SimpleSAML\WSSecurity\XML\auth\Value|null $value
     * @param \SimpleSAML\XML\SerializableElementInterface|null $child
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected string $Name,
        protected ?string $Scope = null,
        protected ?Value $value = null,
        ?SerializableElementInterface $child = null,
        array $namespacedAttributes = [],
    ) {
        Assert::validURI($Name);
        Assert::nullOrValidURI($Scope);

        // One of both must exist, they can't be both null
        Assert::inArray(null, [$value, $child], SchemaViolationException::class);
        Assert::notSame($value, $child, SchemaViolationException::class);

        if ($child !== null) {
            $this->setElements([$child]);
        }
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\Value
     */
    public function getValue(): ?Value
    {
        return $this->value;
    }


    /**
     * Get the value of the Name property.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }


    /**
     * Get the value of the Scope property.
     *
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->Scope;
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

        $value = Value::getChildrenOfClass($xml);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        $children = self::getChildElementsFromXML($xml);
        Assert::maxCount($children, 1, TooManyElementsException::class);

        return new static(
            self::getAttribute($xml, 'Name'),
            self::getOptionalAttribute($xml, 'Scope'),
            array_pop($value),
            array_pop($children),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ContextItemType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $e->setAttribute('Name', $this->getName());
        if ($this->getScope() !== null) {
            $e->setAttribute('Scope', $this->getScope());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getValue()?->toXML($e);

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
