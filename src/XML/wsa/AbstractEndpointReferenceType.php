<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMAttr;
use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;

use function array_pop;
use function sprintf;

/**
 * Class representing WS-addressing EndpointReferenceType.
 *
 * You can extend the class without extending the constructor. Then you can use the methods available
 * and the class will generate an element with the same name as the extending class
 * (e.g. \SimpleSAML\WSSecurity\wsa\EndpointReference).
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractEndpointReferenceType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * The address for this endpoint.
     *
     * @var \SimpleSAML\WSSecurity\XML\wsa\Address
     */
    protected Address $address;

    /**
     * The ReferenceParameters.
     *
     * @var \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters[]
     */
    protected array $referenceParameters;

    /**
     * The Metadata.
     *
     * @var \SimpleSAML\WSSecurity\XML\wsa\Metadata[]
     */
    protected array $metadata;


    /**
     * EndpointReferenceType constructor.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\Address $address
     * @param \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters[] $referenceParameters
     * @param \SimpleSAML\WSSecurity\XML\wsa\Metadata[] $metadata
     * @param \SimpleSAML\XML\Chunk[] $children
     * @param \DOMAttr[] $namespacedAttributes
     *
     * @throws \SimpleSAML\Assert\AssertionFailedException
     */
    final public function __construct(
        Address $address,
        array $referenceParameters = [],
        array $metadata = [],
        array $children = [],
        array $namespacedAttributes = []
    ) {
        $this->setAddress($address);
        $this->setReferenceParameters($referenceParameters);
        $this->setMetadata($metadata);
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
     * Set the value of the address property.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\Address $binding
     */
    protected function setAddress(Address $address): void
    {
        $this->address = $address;
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
     * Set the value of the referenceParameters property.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\ReferenceParameters[] $referenceParameters
     */
    protected function setReferenceParameters(array $referenceParameters): void
    {
        Assert::allIsInstanceOf($referenceParameters, ReferenceParameters::class);
        $this->referenceParameters = $referenceParameters;
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
     * Set the value of the metadata property.
     *
     * @param \SimpleSAML\WSSecurity\XML\wsa\Metadata[] $metadata
     */
    protected function setMetadata(array $metadata): void
    {
        Assert::allIsInstanceOf($metadata, Metadata::class);
        $this->metadata = $metadata;
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
            InvalidDOMElementException::class
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
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        $this->address->toXML($e);

        foreach ($this->referenceParameters as $referenceParameters) {
            $referenceParameters->toXML($e);
        }

        foreach ($this->metadata as $metadata) {
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
