<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\wsu\Created;
use SimpleSAML\WSSecurity\XML\wsu\Expires;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

/**
 * Class defining the LifetimeType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractLifetimeType extends AbstractWstElement
{
    /**
     * AbstractLifetimeType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wsu\Created|null $created
     * @param \SimpleSAML\WSSecurity\XML\wsu\Expires|null $expires
     */
    final public function __construct(
        protected ?Created $created = null,
        protected ?Expires $expires = null,
    ) {
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsu\Created|null
     */
    public function getCreated(): ?Created
    {
        return $this->created;
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wsu\Expires|null
     */
    public function getExpires(): ?Expires
    {
        return $this->expires;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getCreated())
            && empty($this->getExpires());
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

        $created = Created::getChildrenOfClass($xml);
        Assert::maxCount($created, 1, TooManyElementsException::class);

        $expires = Expires::getChildrenOfClass($xml);
        Assert::maxCount($expires, 1, TooManyElementsException::class);


        return new static(
            array_pop($created),
            array_pop($expires),
        );
    }


    /**
     * Add this LifetimeType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getCreated()?->toXML($e);
        $this->getExpires()?->toXML($e);

        return $e;
    }
}
