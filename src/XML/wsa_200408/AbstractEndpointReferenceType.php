<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa_200408;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
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
     * @param \SimpleSAML\WSSecurity\XML\wsa_200408\Address $address
     * @param \SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceProperties|null $referenceProperties
     * @param \SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceParameters|null $referenceParameters
     * @param \SimpleSAML\WSSecurity\XML\wsa_200408\PortType|null $portType
     * @param \SimpleSAML\WSSecurity\XML\wsa_200408\ServiceName|null $serviceName
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     *
     * @throws \SimpleSAML\Assert\AssertionFailedException
     */
    final public function __construct(
        protected Address $address,
        protected ?ReferenceProperties $referenceProperties = null,
        protected ?ReferenceParameters $referenceParameters = null,
        protected ?PortType $portType = null,
        protected ?ServiceName $serviceName = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the address property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa_200408\Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }


    /**
     * Collect the value of the referenceProperties property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceProperties|null
     */
    public function getReferenceProperties(): ?ReferenceProperties
    {
        return $this->referenceProperties;
    }


    /**
     * Collect the value of the referenceParameters property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa_200408\ReferenceParameters|null
     */
    public function getReferenceParameters(): ?ReferenceParameters
    {
        return $this->referenceParameters;
    }


    /**
     * Collect the value of the portType property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa_200408\PortType|null
     */
    public function getPortType(): ?PortType
    {
        return $this->portType;
    }


    /**
     * Collect the value of the serviceName property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsa_200408\ServiceName|null
     */
    public function getServiceName(): ?ServiceName
    {
        return $this->serviceName;
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

        $referenceProperties = ReferenceProperties::getChildrenOfClass($xml);
        Assert::maxCount($referenceProperties, 1, TooManyElementsException::class);

        $referenceParameters = ReferenceParameters::getChildrenOfClass($xml);
        Assert::maxCount($referenceParameters, 1, TooManyElementsException::class);

        $portType = PortType::getChildrenOfClass($xml);
        Assert::maxCount($portType, 1, TooManyElementsException::class);

        $serviceName = ServiceName::getChildrenOfClass($xml);
        Assert::maxCount($serviceName, 1, TooManyElementsException::class);

        return new static(
            array_pop($address),
            array_pop($referenceProperties),
            array_pop($referenceParameters),
            array_pop($portType),
            array_pop($serviceName),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this endpoint reference to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this endpoint to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getAddress()->toXML($e);

        $this->getReferenceProperties()?->toXML($e);
        $this->getReferenceParameters()?->toXML($e);
        $this->getPortType()?->toXML($e);
        $this->getServiceName()?->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
