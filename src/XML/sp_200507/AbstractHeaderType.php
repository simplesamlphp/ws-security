<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function sprintf;

/**
 * Class representing WS security policy HeaderType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractHeaderType extends AbstractSpElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * AbstractHeaderType constructor.
     *
     * @param string $namespace
     * @param string|null $name
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected string $namespace,
        protected ?string $name = null,
        array $namespacedAttributes = [],
    ) {
        Assert::validURI($namespace);
        Assert::nullOrValidQName($name);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the Name property.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * Collect the value of the Namespace property.
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }


    /**
     * Initialize an HeaderType.
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
            sprintf('Unexpected name for HeaderType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'Name' || $attr->getAttrName() === 'Namespace') {
                    unset($namespacedAttributes[$i]);
                }
            }
        }

        return new static(
            self::getAttribute($xml, 'Namespace'),
            self::getOptionalAttribute($xml, 'Name', null),
            $namespacedAttributes,
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

        if ($this->getName() !== null) {
            $e->setAttribute('Name', $this->getName());
        }

        $e->setAttribute('Namespace', $this->getNamespace());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
