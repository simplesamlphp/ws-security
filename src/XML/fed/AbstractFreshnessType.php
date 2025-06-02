<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException};
use SimpleSAML\XML\{ExtendableAttributesTrait, TypedTextContentTrait};
use SimpleSAML\XML\Type\{BooleanValue, UnsignedIntValue};
use SimpleSAML\XML\XsNamespace as NS;

use function intval;
use function sprintf;
use function var_export;

/**
 * Class defining the FreshnessType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractFreshnessType extends AbstractFedElement
{
    use TypedTextContentTrait;
    use ExtendableAttributesTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = UnsignedIntValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractFreshnessType constructor
     *
     * @param \SimpleSAML\XML\Type\UnsignedIntValue $content
     * @param \SimpleSAML\XML\Type\BooleanValue|null $AllowCache
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        UnsignedIntValue $content,
        protected ?BooleanValue $AllowCache = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getAllowCache(): ?BooleanValue
    {
        return $this->AllowCache;
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

        return new static(
            UnsignedIntValue::fromString($xml->textContent),
            self::getOptionalAttribute($xml, 'AllowCache', BooleanValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this IssuerNameType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this issuer name to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        if ($this->getAllowCache() !== null) {
            $e->setAttribute('AllowCache', var_export($this->getAllowCache()->toBoolean(), true));
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
