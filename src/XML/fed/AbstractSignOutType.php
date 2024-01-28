<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A SignOutType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractSignOutType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * SignOutType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\SignOutBasis $signOutBasis
     * @param \SimpleSAML\WSSecurity\XML\fed\Realm|null $realm
     * @param string|null $Id
     * @param \SimpleSAML\XML\SerializableElementInterface[] $childeren
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected SignOutBasis $signOutBasis,
        protected ?Realm $realm = null,
        protected ?string $Id = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the signOutBasis-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\SignOutBasis
     */
    public function getSignOutBasis(): SignOutBasis
    {
        return $this->signOutBasis;
    }


    /**
     * Collect the value of the realm-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\Realm|null
     */
    public function getRealm(): ?Realm
    {
        return $this->realm;
    }


    /**
     * Collect the value of the Id-property
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->Id;
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

        $signOutBasis = SignOutBasis::getChildrenOfClass($xml);
        Assert::minCount($signOutBasis, 1, MissingElementException::class);
        Assert::maxCount($signOutBasis, 1, TooManyElementsException::class);

        $realm = Realm::getChildrenOfClass($xml);
        Assert::maxCount($realm, 1, TooManyElementsException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        $nsAttributes = self::getAttributesNSFromXML($xml);

        $Id = null;
        foreach ($nsAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === C::NS_SEC_UTIL && $attr->getAttrName() === 'Id') {
                $Id = $attr->getAttrValue();
                unset($nsAttributes[$i]);
                break;
            }
        }

        return new static(
            array_pop($signOutBasis),
            array_pop($realm),
            $Id,
            $children,
            $nsAttributes,
        );
    }


    /**
     * Add this SignOutType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getRealm()?->toXML($e);
        $this->getSignOutBasis()->toXML($e);

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $idAttr = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', $this->getId());
            array_unshift($attributes, $idAttr);
        }

        foreach ($attributes as $attr) {
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
