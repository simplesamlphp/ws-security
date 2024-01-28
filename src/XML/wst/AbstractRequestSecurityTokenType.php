<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsp\AppliesTo;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\WSSecurity\XML\wsp\PolicyReference;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the RequestSecurityTokenType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRequestSecurityTokenType extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractRequestSecurityTokenType constructor
     *
     * @param string|null $context
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XML\Attributes[] $namepacedAttributes
     */
    final public function __construct(
        protected ?string $context = null,
        array $children = [],
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidURI($context, SchemaViolationException::class);

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getContext())
            && empty($this->getElements())
            && empty($this->getAttributesNS());
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

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === C::NS_TRUST) {
                $children[] = match ($child->localName) {
                    'AllowPostdating' => AllowPostdating::fromXML($child),
                    'AuthenticationType' => AuthenticationType::fromXML($child),
                    'Authenticator' => Authenticator::fromXML($child),
                    'CanonicalizationAlgorithm' => CanonicalizationAlgorithm::fromXML($child),
                    'Delegatable' => Delegatable::fromXML($child),
                    'DelegateTo' => DelegateTo::fromXML($child),
                    'Encryption' => Encryption::fromXML($child),
                    'EncryptionAlgorithm' => EncryptionAlgorithm::fromXML($child),
                    'EncryptWith' => EncryptWith::fromXML($child),
                    'Entropy' => Entropy::fromXML($child),
                    'Forwardable' => Forwardable::fromXML($child),
                    'KeySize' => KeySize::fromXML($child),
                    'KeyType' => KeyType::fromXML($child),
                    'Lifetime' => Lifetime::fromXML($child),
                    'OnBehalfOf' => OnBehalfOf::fromXML($child),
                    'ProofEncryption' => ProofEncryption::fromXML($child),
                    'Renewing' => Renewing::fromXML($child),
                    'RequestedAttachedReference' => RequestedAttachedReference::fromXML($child),
                    'RequestedProofToken' => RequestedProofToken::fromXML($child),
                    'RequestedSecurityToken' => RequestedSecurityToken::fromXML($child),
                    'RequestedUnattachedReference' => RequestedUnattachedReference::fromXML($child),
                    'RequestType' => RequestType::fromXML($child),
                    'SignatureAlgorithm' => SignatureAlgorithm::fromXML($child),
                    'SignWith' => SignWith::fromXML($child),
                    'Status' => Status::fromXML($child),
                    'UseKey' => UseKey::fromXML($child),
                    default => Chunk::fromXML($child),
                };
                continue;
            } elseif ($child->namespaceURI === C::NS_POLICY) {
                $children[] = match ($child->localName) {
                    'Policy' => Policy::fromXML($child),
                    'PolicyReference' => PolicyReference::fromXML($child),
                    'AppliesTo' => AppliesTo::fromXML($child),
                    default => Chunk::fromXML($child),
                };
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            self::getOptionalAttribute($xml, 'Context'),
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this RequestSecurityTokenType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getContext() !== null) {
            $e->setAttribute('Context', $this->getContext());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
