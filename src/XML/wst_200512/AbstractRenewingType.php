<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

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
     * @param bool|null $allow
     * @param bool|null $ok
     */
    final public function __construct(
        protected ?bool $allow = null,
        protected ?bool $ok = null,
    ) {
    }


    /**
     * @return bool|null
     */
    public function getAllow(): ?bool
    {
        return $this->allow;
    }


    /**
     * @return bool|null
     */
    public function getOk(): ?bool
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
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getOptionalBooleanAttribute($xml, 'Allow', null),
            self::getOptionalBooleanAttribute($xml, 'OK', null),
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
            $e->setAttribute('Allow', $this->getAllow() ? 'true' : 'false');
        }

        if ($this->getOk() !== null) {
            $e->setAttribute('OK', $this->getOk() ? 'true' : 'false');
        }

        return $e;
    }
}
