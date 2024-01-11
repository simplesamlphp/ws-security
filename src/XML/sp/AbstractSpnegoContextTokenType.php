<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;
use ValueError;

use function array_pop;
use function is_string;
use function sprintf;

/**
 * Class representing WS security policy SpnegoContextTokenType.
 *
 * @package tvdijen/ws-security
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


    /**
     * SpnegoContextTokenType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\sp\Issuer|\SimpleSAML\WSSecurity\XML\sp\IssuerName|null $issuer
     * @param \SimpleSAML\WSSecurity\XML\sp\IncludeToken|null $includeToken
     * @param list<\SimpleSAML\XML\ElementInterface> $elts
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected Issuer|IssuerName|null $issuer,
        ?IncludeToken $includeToken = null,
        array $elts = [],
        array $namespacedAttributes = []
    ) {
        $this->setIncludeToken($includeToken);
        $this->setElements($elts);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the Issuer property.
     *
     * @return \SimpleSAML\WSSecurity\XML\sp\Issuer|\SimpleSAML\WSSecurity\XML\sp\IssuerName|null
     */
    public function getIssuer(): Issuer|IssuerName|null
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
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        $qualifiedName = static::getClassName(static::class);
        Assert::eq(
            $xml->localName,
            $qualifiedName,
            sprintf('Unexpected name for IssuedTokenType: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class
        );

        $issuer = Issuer::getChildrenOfClass($xml);
        $issuerName = IssuerName::getChildrenOfClass($xml);
        $issuer = array_merge($issuer, $issuerName);

        try {
            $includeToken = IncludeToken::from(self::getOptionalAttribute($xml, 'IncludeToken', null));
        } catch (ValueError) {
            self::getOptionalAttribute($xml, 'IncludeToken', null);
        }

        $elements = [];
        foreach ($xml->childNodes as $element) {
            if ($element->namespaceURI === static::NS) {
                continue;
            } elseif (!($element instanceof DOMElement)) {
                continue;
            }

            $elements[] = new Chunk($element);
        }

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'IncludeToken') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            }
        }


        return new static(
            array_pop($issuer),
            $includeToken,
            $elements,
            $namespacedAttributes,
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

        if ($this->getIssuer() !== null) {
            $this->getIssuer()->toXML($e);
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
