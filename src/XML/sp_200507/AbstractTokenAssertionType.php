<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;
use ValueError;

use function is_string;
use function sprintf;

/**
 * Class representing WS security policy TokenAssertionType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractTokenAssertionType extends AbstractSpElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use IncludeTokenTypeTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        [null, 'IncludeToken'],
    ];


    /**
     * TokenAssertionType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken|string|null $includeToken
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elts
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        IncludeToken|string|null $includeToken = null,
        array $elts = [],
        array $namespacedAttributes = [],
    ) {
        $this->setIncludeToken($includeToken);
        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getIncludeToken())
            && empty($this->getAttributesNS())
            && empty($this->getElements());
    }


    /**
     * Initialize an TokenAssertionType.
     *
     * Note: this method cannot be used when extending this class, if the constructor has a different signature.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        $qualifiedName = static::getClassName(static::class);
        Assert::eq(
            $xml->localName,
            $qualifiedName,
            sprintf('Unexpected name for TokenAssertionType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        $includeToken = self::getOptionalAttribute($xml, 'IncludeToken', null);
        try {
            $includeToken = IncludeToken::from($includeToken);
        } catch (ValueError) {
        }

        return new static(
            $includeToken,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
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

        if ($this->getIncludeToken() !== null) {
            $e->setAttribute(
                'IncludeToken',
                is_string($this->getIncludeToken()) ? $this->getIncludeToken() : $this->getIncludeToken()->value,
            );
        }

        foreach ($this->getElements() as $elt) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $elt */
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
