<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;

/**
 * Class representing sp:NestedPolicyType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractNestedPolicyType extends AbstractSpElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize an AbstractNestedPolicyType.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsp\Policy $policy
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    final public function __construct(
        protected Policy $policy,
        array $elements = [],
        array $attributes = [],
    ) {
        $this->setElements($elements);
        $this->setAttributesNS($attributes);
    }


    /**
     * Retrieve value of policy-property
     *
     * @return \SimpleSAML\WSSecurity\XML\wsp\Policy
     */
    public function getPolicy(): Policy
    {
        return $this->policy;
    }


    /**
     * Convert XML into a AbstractNestedPolicyType
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $policy = Policy::getChildrenOfClass($xml);
        Assert::minCount($policy, 1, MissingElementException::class);
        Assert::maxCount($policy, 1, TooManyElementsException::class);

        $elements = [];
        foreach ($xml->childNodes as $element) {
            if ($element->namespaceURI === static::NS) {
                continue;
            } elseif ($element->namespaceURI === C::NS_POLICY && $element->localName === 'Policy') {
                continue;
            } elseif (!($element instanceof DOMElement)) {
                continue;
            }

            $elements[] = new Chunk($element);
        }

        return new static(
            array_pop($policy),
            $elements,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this AbstractNestedPolicyType to XML.
     *
     * @param \DOMElement|null $parent The element we should append this AbstractNestedPolicyType to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getPolicy()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $element) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $element */
            $element->toXML($e);
        }

        return $e;
    }
}
