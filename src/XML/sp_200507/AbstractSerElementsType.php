<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function sprintf;

/**
 * Class representing WS security policy SetElementsType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSerElementsType extends AbstractSpElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        [null, 'XPathVersion'],
    ];


    /**
     * AbstractSerElementsType constructor.
     *
     * @param list<\SimpleSAML\WSSecurity\XML\sp_200507\XPath> $xpath
     * @param string|null $xpathVersion
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elts
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $xpath,
        protected ?string $xpathVersion = null,
        array $elts = [],
        array $namespacedAttributes = [],
    ) {
        Assert::minCount($xpath, 1, SchemaViolationException::class);
        Assert::nullOrValidURI($xpathVersion);

        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the XPath property.
     *
     * @return list<\SimpleSAML\WSSecurity\XML\sp_200507\XPath>
     */
    public function getXPath(): array
    {
        return $this->xpath;
    }


    /**
     * Collect the value of the XPathVersion property.
     *
     * @return string|null
     */
    public function getXPathVersion(): ?string
    {
        return $this->xpathVersion;
    }


    /**
     * Initialize an SerElementsType.
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
            sprintf('Unexpected name for SerElementsType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        return new static(
            XPath::getChildrenOfClass($xml),
            self::getOptionalAttribute($xml, 'XPathVersion', null),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getXPathVersion() !== null) {
            $e->setAttribute('XPathVersion', $this->getXPathVersion());
        }

        foreach ($this->getXPath() as $xpath) {
            $xpath->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $elt */
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
