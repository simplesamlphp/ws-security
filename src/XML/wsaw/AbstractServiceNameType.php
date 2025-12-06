<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class defining the ServiceNameType type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractServiceNameType extends AbstractWsawElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** @var string */
    public const TEXTCONTENT_TYPE = QNameValue::class;


    /**
     * AbstractServiceName constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $value
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue|null $endpointName
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        QNameValue $value,
        protected ?NCNameValue $endpointName = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the endpointName property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NCNameValue|null
     */
    public function getEndpointName(): ?NCNameValue
    {
        return $this->endpointName;
    }


    /**
     * Convert this ServiceNameType to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this ServiceNameType.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        if ($this->getEndpointName() !== null) {
            $e->setAttribute('EndpointName', $this->getEndpointName()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
