<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

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
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = QNameValue::class;

    /** The namespace-attribute for the xs:anyElement element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractServiceNameType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $value The QName.
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue|null $portName The PortName.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        QNameValue $value,
        protected ?NCNameValue $portName = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the portName property
     */
    public function getPortName(): ?NCNameValue
    {
        return $this->portName;
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            QNameValue::fromDocument($xml->textContent, $xml),
            self::getOptionalAttribute($xml, 'PortName', NCNameValue::class, null),
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
        $e->textContent = $this->getContent()->getValue();

        if ($this->getPortName() !== null) {
            $e->setAttribute('PortName', $this->getPortName()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
