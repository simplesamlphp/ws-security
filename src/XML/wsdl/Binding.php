<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the Binding element.
 *
 * @package simplesamlphp/ws-security
 */
final class Binding extends AbstractBinding
{
    /** @var string */
    final public const LOCALNAME = 'binding';


    /**
     * Initialize a Binding element.
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

        $operation = BindingOperation::getChildrenOfClass($xml);

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
            self::getAttribute($xml, 'type'),
            $operation,
            $children,
        );
    }
}
