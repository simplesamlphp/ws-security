<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\XML\fed\ClaimDialect;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the ClaimDialectsOfferedType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractClaimDialectsOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractClaimDialectsOfferedType constructor
     *
     * @param array<\SimpleSAML\WSSecurity\XML\fed\ClaimDialect> $claimDialect
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $claimDialect,
        array $namespacedAttributes = []
    ) {
        Assert::notEmpty($claimDialect, SchemaViolationException::class);
        Assert::allIsInstanceOf($claimDialect, ClaimDialect::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array<\SimpleSAML\WSSecurity\XML\fed\ClaimDialect>
     */
    public function getClaimDialect(): array
    {
        return $this->claimDialect;
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

        $claimDialect = ClaimDialect::getChildrenOfClass($xml);
        Assert::minCount(
            $claimDialect,
            1,
            'Missing <fed:ClaimDialect> in ClaimDialectsOffered.',
            MissingElementException::class,
        );

        return new static(
            $claimDialect,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClaimDialectsOfferedType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this ClaimDialectsOfferedType to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getClaimDialect() as $claimDialect) {
            $claimDialect->toXML($e);
        }

        return $e;
    }
}
