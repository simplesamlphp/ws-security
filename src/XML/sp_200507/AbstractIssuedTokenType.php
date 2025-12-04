<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;
use ValueError;

use function array_pop;
use function is_string;
use function sprintf;

/**
 * Class representing WS security policy IssuedTokenType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractIssuedTokenType extends AbstractSpElement
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
     * IssuedTokenType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\RequestSecurityTokenTemplate $requestSecurityTokenTemplate
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\Issuer|null $issuer
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken|string|null $includeToken
     * @param list<\SimpleSAML\XML\SerializableElementInterface> $elts
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected RequestSecurityTokenTemplate $requestSecurityTokenTemplate,
        protected ?Issuer $issuer = null,
        IncludeToken|string|null $includeToken = null,
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
     * Collect the value of the RequestSecurityTokenTemplate property.
     *
     * @return \SimpleSAML\WSSecurity\XML\sp_200507\RequestSecurityTokenTemplate
     */
    public function getRequestSecurityTokenTemplate(): RequestSecurityTokenTemplate
    {
        return $this->requestSecurityTokenTemplate;
    }


    /**
     * Initialize an IssuedTokenType.
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

        $requestSecurityTokenTemplate = RequestSecurityTokenTemplate::getChildrenOfClass($xml);
        Assert::minCount($requestSecurityTokenTemplate, 1, MissingElementException::class);
        Assert::maxCount($requestSecurityTokenTemplate, 1, TooManyElementsException::class);

        $includeToken = self::getOptionalAttribute($xml, 'IncludeToken', StringValue::class, null);
        try {
            $includeToken = IncludeToken::from($includeToken->getValue());
        } catch (ValueError) {
        }

        return new static(
            $requestSecurityTokenTemplate[0],
            array_pop($issuer),
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
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getIncludeToken() !== null) {
            $e->setAttribute(
                'IncludeToken',
                is_string($this->getIncludeToken()) ? $this->getIncludeToken() : $this->getIncludeToken()->value,
            );
        }

        if ($this->getIssuer() !== null) {
            $this->getIssuer()->toXML($e);
        }

        $this->getRequestSecurityTokenTemplate()->toXML($e);

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
