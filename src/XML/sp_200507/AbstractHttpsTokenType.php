<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function sprintf;

/**
 * Class representing WS security policy HttpsTokenType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractHttpsTokenType extends AbstractSpElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        [null, 'RequireClientCertificate'],
    ];


    /**
     * HttpsTokenType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue $requireClientCertificate
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elts
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected BooleanValue $requireClientCertificate,
        array $elts = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the RequireClientCertificate-attribute
     *
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue
     */
    public function getRequireClientCertificate(): BooleanValue
    {
        return $this->requireClientCertificate;
    }


    /**
     * Initialize an HttpsTokenType.
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
            sprintf('Unexpected name for HttpsTokenType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        return new static(
            self::getAttribute($xml, 'RequireClientCertificate', BooleanValue::class),
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

        $e->setAttribute(
            'RequireClientCertificate',
            $this->getRequireClientCertificate()->toBoolean() ? 'true' : 'false',
        );

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
