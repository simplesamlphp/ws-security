<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsu\Type\IDValue;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the Policy element
 *
 * @package simplesamlphp/ws-security
 */
final class Policy extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:Policy
     *
     * @param (\SimpleSAML\WSSecurity\XML\wsp\All|
     *         \SimpleSAML\WSSecurity\XML\wsp\ExactlyOne|
     *         \SimpleSAML\WSSecurity\XML\wsp\Policy|
     *         \SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[] $operatorContent
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Name
     * @param \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null $Id
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        array $operatorContent = [],
        array $children = [],
        protected ?AnyURIValue $Name = null,
        protected ?IDValue $Id = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);

        parent::__construct($operatorContent, $children);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsu\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->Id;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getName(): ?AnyURIValue
    {
        return $this->Name;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    final public function isEmptyElement(): bool
    {
        return empty($this->getName())
            && empty($this->getId())
            && empty($this->getAttributesNS())
            && parent::isEmptyElement();
    }


    /*
     * Convert XML into an wsp:Policy element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    #[\Override]
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'Name') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            } elseif ($attr->getNamespaceURI() === C::NS_SEC_UTIL) {
                if ($attr->getAttrName() === 'Id') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            }
        }

        $operatorContent = $children = [];
        for ($n = $xml->firstChild; $n !== null; $n = $n->nextSibling) {
            if (!($n instanceof DOMElement)) {
                continue;
            } elseif ($n->namespaceURI !== self::NS) {
                $children[] = new Chunk($n);
                continue;
            }

            $operatorContent[] = match ($n->localName) {
                'All' => All::fromXML($n),
                'ExactlyOne' => ExactlyOne::fromXML($n),
                'Policy' => Policy::fromXML($n),
                'PolicyReference' => PolicyReference::fromXML($n),
                default => null,
            };
        }

        return new static(
            $operatorContent,
            $children,
            self::getOptionalAttribute($xml, 'Name', AnyURIValue::class, null),
            $Id,
            $namespacedAttributes,
        );
    }


    /**
     * Convert this wsp:Policy to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:Policy to
     * @return \DOMElement This wsp:Policy element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('Name', $this->getName()->getValue());
        }

        $this->getId()?->toAttribute()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
