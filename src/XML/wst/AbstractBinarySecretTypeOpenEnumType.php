<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\StringElementTrait;

use function array_map;
use function explode;
use function implode;

/**
 * A BinarySecretTypeOpenEnum element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractBinarySecretTypeOpenEnum extends AbstractWstElement
{
    use StringElementTrait;


    /**
     * @param string[] $values
     */
    public function __construct(array $values)
    {
        $values = array_map(
            function (BinarySecretTypeEnum|string $v): string {
                return ($v instanceof BinarySecretTypeEnum) ? $v->value : $v;
            },
            $values,
        );
        Assert::allValidURI($values, SchemaViolationException::class);

        $this->setContent(implode(' ', $values));
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

        return new static(explode(' ', $xml->textContent));
    }
}
