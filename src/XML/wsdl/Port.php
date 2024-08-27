<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the Port element.
 *
 * @package simplesamlphp/ws-security
 */
final class Port extends AbstractPort
{
    /** @var string */
    final public const LOCALNAME = 'port';


    /**
     * Initialize a Port element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::LOCALNAME, InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            } elseif ($child->namespaceURI === static::NS) {
                // Only other namespaces are allowed
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new static(
            self::getAttribute($xml, 'name'),
            self::getAttribute($xml, 'binding'),
            $children,
        );
    }
}
