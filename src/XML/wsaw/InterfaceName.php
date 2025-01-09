<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsaw;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class defining the InterfaceName element
 *
 * @package simplesamlphp/ws-security
 */
final class InterfaceName extends AbstractAttributedQNameType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

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
            $xml->textContent,
            self::getAttributesNSFromXML($xml),
        );
    }
}
