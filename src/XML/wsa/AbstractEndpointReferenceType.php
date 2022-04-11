<?php

declare(strict_types=1);

namespace SimpleSAML\WSTrust\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Constants;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;

use function array_pop;
use function sprintf;

/**
 * Class representing WS-addressing EndpointReferenceType.
 *
 * This class can be used in two different ways:
 *
 *   - You can extend the class without extending the constructor. Then you can use the methods available and the
 *     class will generate an element with the same name as the extending class (e.g. \SimpleSAML\WSTrust\wsa\EndpointReference).
 *
 *   - Alternatively, you may want to extend the type to add new attributes. In that
 *     case, you cannot use this class normally, as if you change the signature of the constructor, you cannot call
 *     fromXML() in this class. In order to process an XML document, you can use the get*Attribute() static methods
 *     from AbstractXMLElement, and reimplement the fromXML() method with them to suit your new constructor.
 *
 * @package tvdijen/ws-trust
 */
abstract class AbstractEndpointReferenceType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = Constants::XS_ANY_NS_OTHER;


    /**
     * The address for this endpoint.
     *
     * @var \SimpleSAML\WSTrust\XML\wsa\Address
     */
    protected Address $address;

    /**
     * The ReferenceParameters.
     *
     * @var \SimpleSAML\WSTrust\XML\wsa\ReferenceParameters
     */
    protected ?ReferenceParameters $referenceParameters;

    /**
     * The Metadata.
     *
     * @var \SimpleSAML\WSTrust\XML\wsa\Metadata
     */
    protected ?Metadata $metadata;


    /**
     * EndpointReferenceType constructor.
     *
     * @param \SimpleSAML\WSTrust\XML\wsa\Address $address
     * @param \SimpleSAML\WSTrust\XML\wsa\ReferenceParameters|null $referenceParameters
     * @param \SimpleSAML\WSTrust\XML\wsa\Metadata|null $metadata
     * @param \SimpleSAML\XML\Chunk[] $children
     *
     * @throws \SimpleSAML\Assert\AssertionFailedException
     */
    public function __construct(
        Address $address,
        array $referenceParameters = null,
        array $metadata = null,
        array $children = []
    ) {
        $this->setAddress($address);
        $this->setReferenceParameters($referenceParameteres);
        $this->setMetadata($metadata);
        $this->setChildren($children);
    }


    /**
     * Collect the value of the address property.
     *
     * @return \SimpleSAML\WSTrust\XML\wsa\Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }


    /**
     * Set the value of the address property.
     *
     * @param \SimpleSAML\WSTrust\XML\wsa\Address|null $binding
     */
    protected function setAddress(?Address $address): void
    {
        $this->address = $address;
    }


    /**
     * Collect the value of the referenceParameters property.
     *
     * @return \SimpleSAML\WSTrust\XML\wsa\ReferenceParameters|null
     */
    public function getReferenceParameters(): ?ReferenceParameters
    {
        return $this->referenceParameters;
    }


    /**
     * Set the value of the referenceParameters property.
     *
     * @param \SimpleSAML\WSTrust\XML\wsa\ReferenceParameters|null $referenceParameters
     */
    protected function setReferenceParameters(?ReferenceParameters $referenceParameters): void
    {
        $this->referenceParameters = $referenceParameters;
    }


    /**
     * Collect the value of the metadata property.
     *
     * @return \SimpleSAML\WSTrust\XML\wsa\Metadata|null
     */
    public function getMetadata(): ?Metadata
    {
        return $this->metadata;
    }


    /**
     * Set the value of the metadata property.
     *
     * @param \SimpleSAML\WSTrust\XML\wsa\Metadata|null $metadata
     */
    protected function setMetadata(?Metadata $metadata): void
    {
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
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException if the qualified name of the supplied element is wrong
     * @throws \SimpleSAML\XML\Exception\MissingAttributeException if the supplied element is missing any of the mandatory attributes
     */
    public static function fromXML(DOMElement $xml): object
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
        Assert::maxCount($referenceParameters, 1, TooManyElementsException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            array_pop($address),
            !empty($referenceParameters) : array_pop($referenceParameters) : null,
            !empty($metadata) : array_pop($metadata) : null,
            $children
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
        $e->toXML($this->address);

        if ($this->referenceParameters !== null) {
            $this->referenceParameters->toXML($e);
        }

        if ($this->metadata !== null) {
            $this->metadata->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            $e->appendChild($e->ownerDocument->importNode($child->toXML(), true));
        }

        return $e;
    }
}
