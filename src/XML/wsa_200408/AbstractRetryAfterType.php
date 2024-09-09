<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function intval;
use function strval;

/**
 * Class representing WS-addressing RetryAfterType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available and the
 * class will generate an element with the same name as the extending class (e.g. \SimpleSAML\WSSecurity\wsa\Address).
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRetryAfterType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractRetryAfterType constructor.
     *
     * @param int $value The long.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected int $value,
        array $namespacedAttributes = [],
    ) {
        Assert::natural($value, SchemaViolationException::class); // Allows 0 as allowed by xs:nonNegativeInteger

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Retrieve the value of the value-attribute
     */
    public function getValue(): int
    {
        return $this->value;
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(intval($xml->textContent), self::getAttributesNSFromXML($xml));
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
        $e->textContent = strval($this->getValue());

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
