<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException, TooManyElementsException};
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\Type\BooleanValue;
use SimpleSAML\XML\XsNamespace as NS;

use function array_filter;
use function array_merge;
use function array_pop;
use function var_export;

/**
 * Class defining the ConstrainedValueType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractConstrainedValueType extends AbstractAuthElement
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractConstrainedValueType constructor
     *
     * @param (
     *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThan|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThanOrEqual|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThan|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueInRangen|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueOneOf
     * ) $value
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XML\Type\BooleanValue|null $assertConstraint
     */
    final public function __construct(
        protected ValueLessThan|ValueLessThanOrEqual|ValueGreaterThan|ValueGreaterThanOrEqual|ValueInRangen|ValueOneOf $value,
        array $children = [],
        protected ?BooleanValue $assertConstraint = null,
    ) {
        $this->setElements($children);
    }


    /**
     * Get the value of the $value property.
     *
     * @return (
     *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThan|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueLessThanOrEqual|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThan|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueGreaterThanOrEqual|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueInRangen|
     *   \SimpleSAML\WSSecurity\XML\auth\ValueOneOf
     * )
     */
    public function getValue(): ValueLessThan|ValueLessThanOrEqual|ValueGreaterThan|ValueGreaterThanOrEqual|ValueInRangen|ValueOneOf
    {
        return $this->value;
    }


    /**
     * Get the value of the assertConstraint property.
     *
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getAssertConstraint(): ?BooleanValue
    {
        return $this->assertConstraint;
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

        $valueLessThan = ValueLessThan::getChildrenOfClass($xml);
        $valueLessThanOrEqual = ValueLessThanOrEqual::getChildrenOfClass($xml);
        $valueGreaterThan = ValueGreaterThan::getChildrenOfClass($xml);
        $valueGreaterThanOrEqual = ValueGreaterThanOrEqual::getChildrenOfClass($xml);
        $valueInRangen = ValueInRangen::getChildrenOfClass($xml);
        $valueOneOf = ValueOneOf::getChildrenOfClass($xml);

        $value = array_filter(array_merge(
            $valueLessThan,
            $valueLessThanOrEqual,
            $valueGreaterThan,
            $valueGreaterThanOrEqual,
            $valueInRangen,
            $valueOneOf,
        ));
        Assert::minCount($value, 1, MissingElementException::class);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        return new static(
            array_pop($value),
            self::getChildElementsFromXML($xml),
            self::getOptionalAttribute($xml, 'AssertConstraint', BooleanValue::class, null),
        );
    }


    /**
     * Add this StructuredValueType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getAssertConstraint() !== null) {
            $e->setAttribute('AssertConstraint', var_export($this->getAssertConstraint()->toBoolean(), true));
        }

        $this->getValue()->toXML($e);

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
