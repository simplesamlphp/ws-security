<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\BooleanValue;

/**
 * Class defining the RenewingType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRenewingType extends AbstractWstElement
{
    /**
     * AbstractRenewingType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $allow
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $ok
     */
    final public function __construct(
        protected ?BooleanValue $allow = null,
        protected ?BooleanValue $ok = null,
    ) {
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getAllow(): ?BooleanValue
    {
        return $this->allow;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getOk(): ?BooleanValue
    {
        return $this->ok;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getAllow())
            && empty($this->getOk());
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getOptionalAttribute($xml, 'Allow', BooleanValue::class, null),
            self::getOptionalAttribute($xml, 'OK', BooleanValue::class, null),
        );
    }


    /**
     * Add this UseKeyType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getAllow() !== null) {
            $e->setAttribute('Allow', $this->getAllow()->getValue());
        }

        if ($this->getOk() !== null) {
            $e->setAttribute('OK', $this->getOk()->getValue());
        }

        return $e;
    }
}
