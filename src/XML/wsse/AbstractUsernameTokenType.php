<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsse;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;
use function array_unshift;

/**
 * Class defining the UsernameTokenType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractUsernameTokenType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id'],
    ];

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Username'],
    ];


    /**
     * AbstractUsernameTokenType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wsse\Username $username
     * @param string|null $Id
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected Username $username,
        protected ?string $Id = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($Id);

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->Id;
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsse\Username
     */
    public function getUsername(): Username
    {
        return $this->username;
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

        $username = Username::getChildrenOfClass($xml);
        Assert::minCount($username, 1, MissingElementException::class);
        Assert::maxCount($username, 1, TooManyElementsException::class);

        return new static(
            array_pop($username),
            $xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id') ? $xml->getAttributeNS(C::NS_SEC_UTIL, 'Id') : null,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $idAttr = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', $this->getId());
            array_unshift($attributes, $idAttr);
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        $this->getUsername()->toXML($e);

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
