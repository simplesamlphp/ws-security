<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException};
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\Type\AnyURIValue;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the IssuerNameType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractIssuerNameType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractIssuerNameType constructor
     *
     * @param \SimpleSAML\XML\Type\AnyURIValue $Uri
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected AnyURIValue $Uri,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XML\Type\AnyURIValue
     */
    public function getUri(): AnyURIValue
    {
        return $this->Uri;
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
            self::getAttribute($xml, 'Uri', AnyURIValue::class),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this IssuerNameType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this issuer name to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->setAttribute('Uri', $this->getUri()->getValue());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
