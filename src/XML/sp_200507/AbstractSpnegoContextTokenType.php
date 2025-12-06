<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\sp_200507\Type\IncludeTokenValue;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_pop;
use function sprintf;

/**
 * Class representing WS security policy SpnegoContextTokenType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSpnegoContextTokenType extends AbstractSpElement
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
     * SpnegoContextTokenType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\Issuer|null $issuer
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\Type\IncludeTokenValue|null $includeToken
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elts
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?Issuer $issuer,
        ?IncludeTokenValue $includeToken = null,
        array $elts = [],
        array $namespacedAttributes = [],
    ) {
        $this->setIncludeToken($includeToken);
        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the Issuer property.
     *
     * @return \SimpleSAML\WSSecurity\XML\sp_200507\Issuer|null
     */
    public function getIssuer(): ?Issuer
    {
        return $this->issuer;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getIssuer())
            && empty($this->getIncludeToken())
            && empty($this->getAttributesNS())
            && empty($this->getElements());
    }


    /**
     * Initialize an SpnegoContextTokenType.
     *
     * Note: this method cannot be used when extending this class, if the constructor has a different signature.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        $qualifiedName = static::getClassName(static::class);
        Assert::eq(
            $xml->localName,
            $qualifiedName,
            sprintf('Unexpected name for IssuedTokenType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        $issuer = Issuer::getChildrenOfClass($xml);

        return new static(
            array_pop($issuer),
            self::getOptionalAttribute($xml, 'IncludeToken', IncludeTokenValue::class, null),
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
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getIncludeToken() !== null) {
            $e->setAttribute('IncludeToken', $this->getIncludeToken()->getValue());
        }

        if ($this->getIssuer() !== null) {
            $this->getIssuer()->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
