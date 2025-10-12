<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\auth\ConstrainedValue;
use SimpleSAML\WSSecurity\XML\auth\Description;
use SimpleSAML\WSSecurity\XML\auth\DisplayName;
use SimpleSAML\WSSecurity\XML\auth\DisplayValue;
use SimpleSAML\WSSecurity\XML\auth\EncryptedValue;
use SimpleSAML\WSSecurity\XML\auth\StructuredValue;
use SimpleSAML\WSSecurity\XML\auth\Value;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_filter;
use function array_merge;
use function array_pop;
use function var_export;

/**
 * Class defining the ClaimType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractClaimType extends AbstractAuthElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractClaimType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $uri
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $optional
     * @param \SimpleSAML\WSSecurity\XML\auth\DisplayName|null $displayName
     * @param \SimpleSAML\WSSecurity\XML\auth\Description|null $description
     * @param \SimpleSAML\WSSecurity\XML\auth\DisplayValue|null $displayValue
     * @param (
     *   \SimpleSAML\WSSecurity\XML\auth\Value|
     *   \SimpleSAML\WSSecurity\XML\auth\EncryptedValue|
     *   \SimpleSAML\WSSecurity\XML\auth\StructuredValue|
     *   \SimpleSAML\WSSecurity\XML\auth\ConstrainedValue|
     *   \SimpleSAML\XML\SerializableElementInterface|
     *   null
     * ) $value
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected AnyURIValue $uri,
        protected ?BooleanValue $optional = null,
        protected ?DisplayName $displayName = null,
        protected ?Description $description = null,
        protected ?DisplayValue $displayValue = null,
        protected null|Value|EncryptedValue|StructuredValue|ConstrainedValue|SerializableElementInterface $value = null,
        array $namespacedAttributes = [],
    ) {
        if (
            !($value === null ||
                $value instanceof Value ||
                $value instanceof ConstrainedValue ||
                $value instanceof StructuredValue ||
                $value instanceof EncryptedValue)
        ) {
            /** @psalm-var \SimpleSAML\XML\AbstractElement|\SimpleSAML\XML\Chunk $value */
            Assert::notSame($value->getNamespaceURI(), static::NS);
        }
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the $value property.
     *
     * @return (
     *   \SimpleSAML\WSSecurity\XML\auth\Value|
     *   \SimpleSAML\WSSecurity\XML\auth\EncryptedValue|
     *   \SimpleSAML\WSSecurity\XML\auth\StructuredValue|
     *   \SimpleSAML\WSSecurity\XML\auth\ConstrainedValue|
     *   \SimpleSAML\XML\SerializableElementInterface|
     *   null
     * ) $value
     */
    public function getValue(): null|Value|EncryptedValue|StructuredValue|ConstrainedValue|SerializableElementInterface
    {
        return $this->value;
    }


    /**
     * Get the value of the displayName property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\DisplayName|null
     */
    public function getDisplayName(): ?DisplayName
    {
        return $this->displayName;
    }


    /**
     * Get the value of the displayValue property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\DisplayValue|null
     */
    public function getDisplayValue(): ?DisplayValue
    {
        return $this->displayValue;
    }


    /**
     * Get the value of the description property.
     *
     * @return \SimpleSAML\WSSecurity\XML\auth\Description|null
     */
    public function getDescription(): ?Description
    {
        return $this->description;
    }


    /**
     * Get the value of the uri property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getURI(): AnyURIValue
    {
        return $this->uri;
    }


    /**
     * Get the value of the optional property.
     *
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getOptional(): ?BooleanValue
    {
        return $this->optional;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $displayName = DisplayName::getChildrenOfClass($xml);
        Assert::maxCount($displayName, 1, TooManyElementsException::class);

        $displayValue = DisplayValue::getChildrenOfClass($xml);
        Assert::maxCount($displayValue, 1, TooManyElementsException::class);

        $description = Description::getChildrenOfClass($xml);
        Assert::maxCount($description, 1, TooManyElementsException::class);

        $simpleValue = Value::getChildrenOfClass($xml);
        $structuredValue = StructuredValue::getChildrenOfClass($xml);
        $encryptedValue = EncryptedValue::getChildrenOfClass($xml);
        $constrainedValue = ConstrainedValue::getChildrenOfClass($xml);
        $otherValue = self::getChildElementsFromXML($xml);

        $value = array_filter(array_merge(
            $simpleValue,
            $structuredValue,
            $encryptedValue,
            $constrainedValue,
            $otherValue,
        ));
        Assert::maxCount($value, 1, TooManyElementsException::class);

        return new static(
            self::getAttribute($xml, 'Uri', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'Optional', BooleanValue::class, null),
            array_pop($displayName),
            array_pop($description),
            array_pop($displayValue),
            array_pop($value),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClaimType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $e->setAttribute('Uri', $this->getURI()->getValue());
        if ($this->getOptional() !== null) {
            $e->setAttribute('Optional', var_export($this->getOptional()->toBoolean(), true));
        }

        $this->getDisplayName()?->toXML($e);
        $this->getDescription()?->toXML($e);
        $this->getDisplayValue()?->toXML($e);
        $this->getValue()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
