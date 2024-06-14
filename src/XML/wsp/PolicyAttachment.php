<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsp\AppliesTo;
use SimpleSAML\WSSecurity\XML\wsp\Policy;
use SimpleSAML\WSSecurity\XML\wsp\PolicyReference;
use SimpleSAML\WSSecurity\XML\wsse\Security;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_merge;

/**
 * Class representing a wsp:PolicyAttachment element.
 *
 * @package simplesamlphp/ws-security
 */
final class PolicyAttachment extends AbstractWspElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:PolicyAttachment
     *
     * @param \SimpleSAML\WSSecurity\XML\wsp\AppliesTo $appliesTo
     * @param (\SimpleSAML\WSSecurity\XML\wsp\Policy|\SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[] $policies
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected AppliesTo $appliesTo,
        protected array $policies,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the AppliesTo property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsp\AppliesTo
     */
    public function getAppliesTo(): AppliesTo
    {
        return $this->appliesTo;
    }


    /**
     * Collect the value of the Policies property.
     *
     * @return (\SimpleSAML\WSSecurity\XML\wsp\Policy|\SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[]
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }


    /*
     * Convert XML into an wsp:PolicyAttachment element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $appliesTo = AppliesTo::getChildrenOfClass($xml);
        Assert::minCount($appliesTo, 1, MissingElementException::class);
        Assert::maxCount($appliesTo, 1, TooManyElementsException::class);

        $policy = Policy::getChildrenOfClass($xml);
        $policyReference = PolicyReference::getChildrenOfClass($xml);
        $policies = array_merge($policy, $policyReference);
        Assert::minCount($policies, 1, MissingElementException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                continue;
            } elseif ($child->namespaceURI === C::NS_SEC_EXT && $child->localName === 'Security') {
                $children[] = Security::fromXML($child);
            } else {
                $children[] = new Chunk($child);
            }
        }

        return new static(
            $appliesTo[0],
            $policies,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:PolicyAttachment to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:AppliesTo to.
     * @return \DOMElement This wsp:AppliesTo element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getAppliesTo()->toXML($e);

        foreach ($this->getPolicies() as $pol) {
            $pol->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
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
