<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\StringElementTrait;

use function in_array;
use function sprintf;

/**
 * A AutomaticPseudonyms element
 *
 * @package simplesamlphp/ws-security
 */
final class AutomaticPseudonyms extends AbstractFedElement implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
    use StringElementTrait;


    /**
     * @param bool $content
     */
    public function __construct(bool $content)
    {
        $this->setContent($content ? 'true' : 'false');
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        Assert::oneOf(
            $xml->textContent,
            ['0', '1', 'false', 'true'],
            sprintf(
                'The value \'%s\' of an %s:%s element must be a boolean.',
                $xml->textContent,
                static::NS_PREFIX,
                static::getLocalName(),
            ),
        );

        return new static(in_array($xml->textContent, ['1', 'true'], true));
    }
}
