<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Class defining the ServiceName element
 *
 * @package simplesamlphp/ws-security
 */
final class ServiceName extends AbstractServiceNameType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

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
            QNameValue::fromDocument($xml->textContent, $xml),
            self::getOptionalAttribute($xml, 'EndpointName', NCNameValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
