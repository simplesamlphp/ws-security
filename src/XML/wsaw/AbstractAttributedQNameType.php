<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class defining the AttributedQName type
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAttributedQNameType extends AbstractWsawElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** @var string */
    public const TEXTCONTENT_TYPE = QNameValue::class;


    /**
     * AbstractAttributedQNameType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $value
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        QNameValue $value,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Convert this AttributedQNameType to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this AttributedQNameType.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
