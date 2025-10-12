<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\auth;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;

use function array_pop;

/**
 * Class representing WS-authorization EncryptedValueType.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractEncryptedValueType extends AbstractAuthElement
{
    /**
     * AbstractEncryptedValueType constructor.
     *
     * @param \SimpleSAML\XMLSecurity\XML\xenc\EncryptedData $encryptedData
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $descriptionCondition
     */
    final public function __construct(
        protected EncryptedData $encryptedData,
        protected ?AnyURIValue $descriptionCondition = null,
    ) {
    }


    /**
     * Get the value of the $descriptionCondition property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getDescriptionCondition(): ?AnyURIValue
    {
        return $this->descriptionCondition;
    }


    /**
     * Get the value of the $encryptedData property.
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\EncryptedData
     */
    public function getEncryptedData(): EncryptedData
    {
        return $this->encryptedData;
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $encryptedData = EncryptedData::getChildrenOfClass($xml);
        Assert::minCount($encryptedData, 1, MissingElementException::class);
        Assert::maxCount($encryptedData, 1, TooManyElementsException::class);

        return new static(
            array_pop($encryptedData),
            self::getOptionalAttribute($xml, 'DescriptionCondition', AnyURIValue::class, null),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('DescriptionCondition', $this->getDescriptionCondition()->getValue());

        $this->getEncryptedData()->toXML($e);

        return $e;
    }
}
