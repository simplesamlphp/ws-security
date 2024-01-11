<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

use function array_pop;

/**
 * Class representing WS-authorization ConstrainedSingleValueType.
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractConstrainedSingleValueType extends AbstractAuthElement
{
    /**
     * AbstractConstrainedSingleValueType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\auth\Value $value
     * @param \SimpleSAML\WSSecurity\XML\auth\StructuredValue $structuredValue
     */
    final public function __construct(
        protected ?Value $value = null,
        protected ?StructuredValue $structuredValue = null
    ) {
        Assert::oneOf(
            null,
            [$structuredValue, $value],
            'Can only have one of StructuredValue/Value',
        );
    }


    /**
     * Get the value of the $structuredValue property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\StructuredValue|null
     */
    public function getStructuredValue(): ?StructuredValue
    {
        return $this->structuredValue;
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\Value|null
     */
    public function getValue(): ?Value
    {
        return $this->value;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->value) && empty($this->structuredValue);
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

        $structuredValue = StructuredValue::getChildrenOfClass($xml);
        Assert::maxCount($structuredValue, 1, TooManyElementsException::class);

        $value = Value::getChildrenOfClass($xml);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        return new static(
            array_pop($value),
            array_pop($structuredValue),
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

        $this->getStructuredValue()?->toXML($e);
        $this->getValue()?->toXML($e);

        return $e;
    }
}
