<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\fed\IssuerName;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException, SchemaViolationException};
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the LogicalServiceNamesOfferedType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractLogicalServiceNamesOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * LogicalServiceNamesOfferedType constructor
     *
     * @param array<\SimpleSAML\WSSecurity\XML\fed\IssuerName> $issuerName
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $issuerName,
        array $namespacedAttributes = [],
    ) {
        Assert::notEmpty($issuerName, SchemaViolationException::class);
        Assert::allIsInstanceOf($issuerName, IssuerName::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array<\SimpleSAML\WSSecurity\XML\fed\IssuerName>
     */
    public function getIssuerName(): array
    {
        return $this->issuerName;
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

        $issuerName = IssuerName::getChildrenOfClass($xml);
        Assert::minCount(
            $issuerName,
            1,
            'Missing <fed:IssuerName> in LogicalServiceNamesOfferedType.',
            MissingElementException::class,
        );

        return new static(
            $issuerName,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this LogicalServiceNamesOfferedType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this LogicalServiceNamesOfferedType to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getIssuerName() as $issuerName) {
            $issuerName->toXML($e);
        }

        return $e;
    }
}
