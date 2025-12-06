<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\auth\ClaimType;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the ClaimTypesOfferedType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractClaimTypesOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractClaimTypesOfferedType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\auth\ClaimType[] $claimType
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected array $claimType,
        array $namespacedAttributes = [],
    ) {
        Assert::notEmpty($claimType, SchemaViolationException::class);
        Assert::allIsInstanceOf($claimType, ClaimType::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\auth\ClaimType[]
     */
    public function getClaimType(): array
    {
        return $this->claimType;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $claimType = ClaimType::getChildrenOfClass($xml);
        Assert::minCount(
            $claimType,
            1,
            MissingElementException::class,
        );

        return new static(
            $claimType,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClaimTypesOfferedType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this ClaimTypesOfferedType to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getClaimType() as $claimType) {
            $claimType->toXML($e);
        }

        return $e;
    }
}
