<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;
use function sprintf;

/**
 * Class representing WS-addressing EndpointReferenceType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available
 * and the class will generate an element with the same name as the extending class
 * (e.g. \SimpleSAML\WSSecurity\wsa\EndpointReference).
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractEndpointReferenceType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * EndpointReferenceType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\Address $address
     * @param \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters[] $referenceParameters
     * @param \SimpleSAML\WSSecurity\XML\wsa\Metadata[] $metadata
     * @param \SimpleSAML\XML\Chunk[] $children
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     *
     * @throws \SimpleSAML\Assert\AssertionFailedException
     */
    final public function __construct(
        protected Address $address,
        protected array $referenceParameters = [],
        protected array $metadata = [],
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOf($referenceParameters, ReferenceParameters::class);
        Assert::allIsInstanceOf($metadata, Metadata::class);

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the address property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa\Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }


    /**
     * Collect the value of the referenceParameters property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters[]
     */
    public function getReferenceParameters(): array
    {
        return $this->referenceParameters;
    }


    /**
     * Collect the value of the metadata property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa\Metadata[]
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }


    /**
     * Initialize an EndpointReferenceType.
     *
     * Note: this method cannot be used when extending this class, if the constructor has a different signature.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     * @throws \SimpleSAML\XML\Exception\MissingAttributeException
     *   if the supplied element is missing any of the mandatory attributes
     */
    public static function fromXML(DOMElement $xml): static
    {
        $qualifiedName = static::getClassName(static::class);
        Assert::eq(
            $xml->localName,
            $qualifiedName,
            sprintf('Unexpected name for endpoint reference: %s. Expected: %s.', $xml->localName, $qualifiedName),
            InvalidDOMElementException::class,
        );

        $address = Address::getChildrenOfClass($xml);
        Assert::minCount($address, 1, MissingElementException::class);
        Assert::maxCount($address, 1, TooManyElementsException::class);

        $referenceParameters = ReferenceParameters::getChildrenOfClass($xml);
        $metadata = Metadata::getChildrenOfClass($xml);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === C::NS_ADDR) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            array_pop($address),
            $referenceParameters,
            $metadata,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this endpoint reference to an XML element.
     *
     * @param \DOMElement $parent The element we should append this endpoint to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getAddress()->toXML($e);

        foreach ($this->getReferenceParameters() as $referenceParameters) {
            $referenceParameters->toXML($e);
        }

        foreach ($this->getMetadata() as $metadata) {
            $metadata->toXML($e);
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
