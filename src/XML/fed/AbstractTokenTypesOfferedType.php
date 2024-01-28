<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\XML\fed\TokenType;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the TokenTypesOffered element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractTokenTypesOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractTokenTypesOffered constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\TokenType[] $tokenType
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param array $namespacedAttributes
     */
    final public function __construct(
        protected array $tokenType,
        array $children = [],
        array $namespacedAttributes = []
    ) {
        Assert::notEmpty($tokenType, SchemaViolationException::class);
        Assert::allIsInstanceOf($tokenType, TokenType::class);

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array
     */
    public function getTokenType(): array
    {
        return $this->tokenType;
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

        $tokenType = TokenType::getChildrenOfClass($xml);
        Assert::minCount(
            $tokenType,
            1,
            'Missing <fed:TokenType> in TokenTypesOffered.',
            MissingElementException::class,
        );

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            $tokenType,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this TokenTypesOffered to an XML element.
     *
     * @param \DOMElement $parent The element we should append this TokenTypesOffered to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getTokenType() as $tokenType) {
            $tokenType->toXML($e);
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
