<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\QNameElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class representing WS-addressing ServiceNameType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available and the class
 * will generate an element with the same name as the extending class
 * (e.g. \SimpleSAML\WSSecurity\wsa\ServiceName).
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractServiceNameType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use QNameElementTrait;

    /** The namespace-attribute for the xs:anyElement element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractServiceNameType constructor.
     *
     * @param string $value The QName.
     * @param string|null $portName The PortName.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        string $value,
        protected ?string $portName = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($portName, SchemaViolationException::class);

        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the portName property
     */
    public function getPortName(): ?string
    {
        return $this->portName;
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

        return new static(
            $xml->textContent,
            self::getOptionalAttribute($xml, 'PortName', null),
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
        $e->textContent = $this->getContent();

        if ($this->getPortName() !== null) {
            $e->setAttribute('PortName', $this->getPortName());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
