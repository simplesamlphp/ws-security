<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\XML\fed\Type\EmailAddressValue;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;

/**
 * An EMail element
 *
 * @package simplesamlphp/ws-security
 */
final class EMail extends AbstractAttributeExtensibleString
{
    /**
     * @param \SimpleSAML\WSSecurity\XML\fed\Type\EmailAddressValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(EmailAddressValue $content, array $namespacedAttributes = [])
    {
        parent::__construct($content, $namespacedAttributes);
    }


    /**
     * Create a class from XML
     *
     * @param \DOMElement $xml
     * @return static
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            EmailAddressValue::fromString($xml->textContent),
            self::getAttributesNSFromXML($xml),
        );
    }
}
