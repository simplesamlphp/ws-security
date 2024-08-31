<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the Definitions element.
 *
 * @package simplesamlphp/ws-security
 */
final class Definitions extends AbstractDefinitions
{
    /** @var string */
    final public const LOCALNAME = 'definitions';


    /**
     * Initialize a Definitions element.
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

        $import = Import::getChildrenOfClass($xml);
        $types = Types::getChildrenOfClass($xml);
        $message = Message::getChildrenOfClass($xml);
        $portType = PortType::getChildrenOfClass($xml);
        $binding = Binding::getChildrenOfClass($xml);
        $service = Service::getChildrenOfClass($xml);

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
            self::getOptionalAttribute($xml, 'targetNamespace'),
            self::getOptionalAttribute($xml, 'name'),
            $import,
            $types,
            $message,
            $portType,
            $binding,
            $service,
            $children,
        );
    }
}
