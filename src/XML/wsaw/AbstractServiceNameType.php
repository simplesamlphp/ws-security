<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\QNameElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Abstract class defining the ServiceNameType type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractServiceNameType extends AbstractWsawElement
{
    use ExtendableAttributesTrait;
    use QNameElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractServiceName constructor
     *
     * @param string $value
     * @param string|null $endpointName
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        string $value,
        protected ?string $endpointName = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidNCName($endpointName, SchemaViolationException::class);

        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the endpointName property.
     *
     * @return string|null
     */
    public function getEndpointName(): ?string
    {
        return $this->endpointName;
    }


    /**
     * Convert this ServiceNameType to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this ServiceNameType.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        if ($this->getEndpointName() !== null) {
            $e->setAttribute('EndpointName', $this->getEndpointName());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
