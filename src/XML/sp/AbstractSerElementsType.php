<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function sprintf;

/**
 * Class representing WS security policy SetElementsType.
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractSerElementsType extends AbstractSpElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * AbstractSerElementsType constructor.
     *
     * @param list<\SimpleSAML\WSSecurity\XML\sp\XPath> $xpath
     * @param string|null $xpathVersion
     * @param list<\SimpleSAML\XML\ElementInterface> $elts
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $xpath,
        protected ?string $xpathVersion = null,
        array $elts = [],
        array $namespacedAttributes = []
    ) {
        Assert::minCount($xpath, 1, SchemaViolationException::class);
        Assert::nullOrValidURI($xpathVersion);

        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the XPath property.
     *
     * @return list<\SimpleSAML\WSSecurity\XML\sp\XPath>
     */
    public function getXPath(): array
    {
        return $this->xpath;
    }


    /**
     * Collect the value of the XPathVersion property.
     *
     * @return string
     */
    public function getXPathVersion(): string
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
            InvalidDOMElementException::class
        );

        $elements = [];
        foreach ($xml->childNodes as $element) {
            if ($element->namespaceURI === static::NS) {
                continue;
            } elseif (!($element instanceof DOMElement)) {
                continue;
            }

            $elements[] = new Chunk($element);
        }

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'XPathVersion') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            }
        }

        return new static(
            XPath::getChildrenOfClass($xml),
            self::getOptionalAttribute($xml, 'XPathVersion', null),
            $elements,
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

        if ($this->getXPathVersion() !== null) {
            $e->setAttribute('XPathVersion', $this->getXPathVersion());
        }

        foreach ($this->getXPath() as $xpath) {
            $xpath->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
