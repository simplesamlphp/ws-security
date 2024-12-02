<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function str_replace;

/**
 * Class defining the PolicyReference element
 *
 * @package simplesamlphp/ws-security
 */
final class PolicyReference extends AbstractWspElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:PolicyReference
     *
     * @param string $URI
     * @param string|null $Digest
     * @param string $DigestAlgorithm
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        protected string $URI,
        protected ?string $Digest = null,
        protected ?string $DigestAlgorithm = 'http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc',
        array $namespacedAttributes = [],
    ) {
        Assert::validURI($URI, SchemaViolationException::class);
        Assert::nullOrStringPlausibleBase64($Digest, SchemaViolationException::class);
        Assert::nullOrValidURI($DigestAlgorithm, SchemaViolationException::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string
     */
    public function getURI(): string
    {
        return $this->URI;
    }


    /**
     * @return string|null
     */
    public function getDigest(): ?string
    {
        return $this->Digest ? str_replace(["\f", "\r", "\n", "\t", "\v", ' '], '', $this->Digest) : null;
    }


    /**
     * @return string|null
     */
    public function getDigestAlgorithm(): ?string
    {
        return $this->DigestAlgorithm;
    }


    /*
     * Convert XML into an wsp:PolicyReference element
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

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'URI') {
                    unset($namespacedAttributes[$i]);
                    continue;
                } elseif ($attr->getAttrName() === 'Digest') {
                    unset($namespacedAttributes[$i]);
                    continue;
                } elseif ($attr->getAttrName() === 'DigestAlgorithm') {
                    unset($namespacedAttributes[$i]);
                    continue;
                }
            }
        }

        return new static(
            self::getAttribute($xml, 'URI'),
            self::getOptionalAttribute($xml, 'Digest', null),
            self::getOptionalAttribute($xml, 'DigestAlgorithm', null),
            $namespacedAttributes,
        );
    }


    /**
     * Convert this wsp:PolicyReference to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:Policy to
     * @return \DOMElement This wsp:PolicyReference element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('URI', $this->getURI());

        if ($this->getDigest() !== null) {
            $e->setAttribute('Digest', $this->getDigest());
        }

        if ($this->getDigestAlgorithm() !== null) {
            $e->setAttribute('DigestAlgorithm', $this->getDigestAlgorithm());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
