<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;

use function array_pop;

/**
 * Class representing WS-authorization ConstrainedManyValueType.
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractConstrainedManyValueType extends AbstractAuthElement
{
    /**
     * AbstractConstrainedManyValueType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\auth\Value[] $value
     * @param \SimpleSAML\WSSecurity\XML\auth\StructuredValue[] $structuredValue
     */
    final public function __construct(
        protected array $value = [],
        protected array $structuredValue = []
    ) {
        Assert::oneOf(
            [],
            [$structuredValue, $value],
            'Can only have one of StructuredValue/Value',
        );
    }


    /**
     * Get the value of the $structuredValue property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\StructuredValue[]
     */
    public function getStructuredValue(): array
    {
        return $this->structuredValue;
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\Value[]
     */
    public function getValue(): array
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
        return empty($this->value) && empty($this->constrainedValue);
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
        $value = Value::getChildrenOfClass($xml);

        return new static(
            $value,
            $structuredValue,
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

        foreach ($this->getStructuredValue() as $sv) {
            $sv->toXML($e);
        }

        foreach ($this->getValue() as $v) {
            $v->toXML($e);
        }

        return $e;
    }
}
