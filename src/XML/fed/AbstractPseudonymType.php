<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsu\Expires;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A PseudonymType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * PseudonymType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis $pseudonymBasis
     * @param \SimpleSAML\WSSecurity\XML\fed\RelativeTo $relativeTo
     * @param \SimpleSAML\WSSecurity\XML\wsu\Expires|null $expires
     * @param array<\SimpleSAML\WSSecurity\XML\fed\SecurityToken> $securityToken
     * @param array<\SimpleSAML\WSSecurity\XML\fed\ProofToken> $proofToken
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected PseudonymBasis $pseudonymBasis,
        protected RelativeTo $relativeTo,
        protected ?Expires $expires = null,
        protected array $securityToken = [],
        protected array $proofToken = [],
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::minCount($securityToken, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $securityToken,
            SecurityToken::class,
            SchemaViolationException::class,
        );
        Assert::minCount($proofToken, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $proofToken,
            ProofToken::class,
            SchemaViolationException::class,
        );

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the pseudonymBasis-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\PseudonymBasis
     */
    public function getPseudonymBasis(): PseudonymBasis
    {
        return $this->pseudonymBasis;
    }


    /**
     * Collect the value of the relativeTo-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\RelativeTo
     */
    public function getRelativeTo(): RelativeTo
    {
        return $this->relativeTo;
    }


    /**
     * Collect the value of the expires-property
     *
     * @return \SimpleSAML\WSSecurity\XML\wsu\Expires|null
     */
    public function getExpires(): ?Expires
    {
        return $this->expires;
    }


    /**
     * Collect the value of the securityToken-property
     *
     * @return array<\SimpleSAML\WSSecurity\XML\fed\SecurityToken>
     */
    public function getSecurityToken(): array
    {
        return $this->securityToken;
    }


    /**
     * Collect the value of the proofToken-property
     *
     * @return array<\SimpleSAML\WSSecurity\XML\fed\ProofToken>
     */
    public function getProofToken(): array
    {
        return $this->proofToken;
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

        $children = $pseudonymBasis = $relativeTo = $expires = $securityToken = $proofToken = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                if ($child->localName === 'PseudonymBasis') {
                    $pseudonymBasis[] = PseudonymBasis::fromXML($child);
                } elseif ($child->localName === 'RelativeTo') {
                    $relativeTo[] = RelativeTo::fromXML($child);
                } elseif ($child->localName === 'SecurityToken') {
                    $securityToken[] = SecurityToken::fromXML($child);
                } elseif ($child->localName === 'ProofToken') {
                    $proofToken[] = ProofToken::fromXML($child);
                } else {
                    $children[] = new Chunk($child);
                }
                continue;
            } elseif ($child->namespaceURI === C::NS_SEC_UTIL) {
                if ($child->localName === 'Expires') {
                    $expires[] = Expires::fromXML($child);
                } else {
                    $children[] = new Chunk($child);
                }
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            array_pop($pseudonymBasis),
            array_pop($relativeTo),
            array_pop($expires),
            $securityToken,
            $proofToken,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this PseudonymType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getPseudonymBasis()->toXML($e);
        $this->getRelativeTo()->toXML($e);
        $this->getExpires()?->toXML($e);

        foreach ($this->getSecurityToken() as $st) {
            $st->toXML($e);
        }

        foreach ($this->getProofToken() as $pt) {
            $pt->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
