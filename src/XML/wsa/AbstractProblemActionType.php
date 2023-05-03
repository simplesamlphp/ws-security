<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;

/**
 * Class representing WS-addressing ProblemActionType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available and the
 * class will generate an element with the same name as the extending class (e.g. \SimpleSAML\WSSecurity\wsa\ProblemAction).
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractProblemActionType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = Constants::XS_ANY_NS_OTHER;


    /**
     * AbstractProblemActionType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\Action|null $action
     * @param \SimpleSAML\WSSecurity\XML\wsa\SoapAction|null $soapAction
     * @param \DOMAttr[] $namespacedAttributes
     */
    final public function __construct(
        protected ?Action $action = null,
        protected ?SoapAction $soapAction = null,
        array $namespacedAttributes = []
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->action) && empty($this->soapAction) && empty($this->namespacedAttributes);
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->action?->toXML($e);
        $this->soapAction?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        return $e;
    }
}
