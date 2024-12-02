<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsx;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;

/**
 * Class defining the GetMetadata element
 *
 * @package simplesamlphp/ws-security
 */
final class GetMetadata extends AbstractWsxElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * GetMetadata constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wsx\Dialect|null $dialect
     * @param \SimpleSAML\WSSecurity\XML\wsx\Identifier|null $identifier
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?Dialect $dialect = null,
        protected ?Identifier $identifier = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the dialect property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsx\Dialect|null
     */
    public function getDialect(): ?Dialect
    {
        return $this->dialect;
    }


    /**
     * Get the identifier property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wsx\Identifier|null
     */
    public function getIdentifier(): ?Identifier
    {
        return $this->identifier;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getDialect())
            && empty($this->getIdentifier())
            && empty($this->getAttributesNS());
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

        $dialect = Dialect::getChildrenOfClass($xml);
        Assert::maxCount($dialect, 1, TooManyElementsException::class);

        $identifier = Identifier::getChildrenOfClass($xml);
        Assert::maxCount($identifier, 1, TooManyElementsException::class);

        return new static(
            array_pop($dialect),
            array_pop($identifier),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this GetMetadata to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this GetMetadata to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getDialect()?->toXML($e);
        $this->getIdentifier()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
