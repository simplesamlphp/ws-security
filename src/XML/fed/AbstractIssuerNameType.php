<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class defining the IssuerNameType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractIssuerNameType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * AbstractIssuerNameType constructor
     *
     * @param string|null $Uri
     * @param array $namespacedAttributes
     */
    public function __construct(
        protected string $Uri,
        array $namespacedAttributes = []
    ) {
        Assert::validURI($Uri, SchemaViolationException::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string
     */
    public function getUri(): string
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
            self::getOptionalAttribute($xml, 'Uri', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this IssuerNameType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this issuer name to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getUri() !== null) {
            $e->setAttribute('Uri', $this->getUri());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
