<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;
use ValueError;

use function sprintf;

/**
 * Class defining the Anonymous element
 *
 * @package simplesamlphp/ws-security
 */
final class Anonymous extends AbstractAnonymousType
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * Anonymous constructor
     *
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        AnonymousEnum $value,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($value);

        $this->setAttributesNS($namespacedAttributes);
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

        try {
            $anonymous = AnonymousEnum::from($xml->textContent);
        } catch (ValueError) {
            throw new SchemaViolationException(
                sprintf('Unknown value \'%s\' for Anonymous element.', $xml->textContent),
            );
        }

        return new static($anonymous, self::getAttributesNSFromXML($xml));
    }


    /**
     * Convert this Anonymous to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this Anonymous.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
