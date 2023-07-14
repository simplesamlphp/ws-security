<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\fed\ClaimDialect;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class defining the ClaimDialectsOfferedType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractClaimDialectsOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * AbstractClaimDialectsOfferedType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimDialect[] $claimDialect
     * @param array $namespacedAttributes
     */
    public function __construct(
        protected array $claimDialect,
        array $namespacedAttributes = []
    ) {
        Assert::notEmpty($claimDialect, SchemaViolationException::class);
        Assert::allIsInstanceOf($claimDialect, ClaimDialect::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array
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
