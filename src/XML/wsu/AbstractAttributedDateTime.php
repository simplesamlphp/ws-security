<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsu;

use DateTimeImmutable;
use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\Exception\ProtocolViolationException;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;

/**
 * Abstract class defining the AttributedDateTime type
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractAttributedDateTime extends AbstractWsuElement
{
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_OTHER;


    /**
     * AbstractAttributedDateTime constructor
     *
     * @param \DateTimeImmutable $dateTime
     * @param string|null $Id
     * @param array $namespacedAttributes
     */
    final public function __construct(
        protected DateTimeImmutable $dateTime,
        protected ?string $Id = null,
        array $namespacedAttributes = []
    ) {
        Assert::nullOrValidNCName($Id);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->Id;
    }


    /**
     * Collect the value of the dateTime property
     *
     * @return \DateTimeImmutable
     */
    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
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

        // Time values MUST be expressed in the UTC timezone using the 'Z' timezone identifier
        // Strip sub-seconds
        $xml->textContent = preg_replace('/([.][0-9]+Z)$/', 'Z', $xml->textContent, 1);
        Assert::validDateTimeZulu($xml->textContent, ProtocolViolationException::class);

        $Id = null;
        if ($xml->hasAttributeNS(static::NS, 'Id')) {
            $Id = $xml->getAttributeNS(static::NS, 'Id');
        }

        return new static(new DateTimeImmutable($xml->textContent), $Id, self::getAttributesNSFromXML($xml));
    }


    /**
     * @param \DOMElement|null $parent
     * @return \DOMElement
     */
    final public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getDateTime()->format(C::DATETIME_FORMAT);

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $attributes[] = new XMLAttribute(static::NS, 'wsu', 'Id', $this->getId());
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
