<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\StringElementTrait;

use function array_map;
use function explode;
use function implode;

/**
 * A ComputedKeyOpenEnum element
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractComputedKeyOpenEnum extends AbstractWstElement
{
    use StringElementTrait;


    /**
     * @param (\SimpleSAML\WSSecurity\XML\wst_200502\ComputedKeyEnum|string)[] $values
     */
    public function __construct(array $values)
    {
        $values = array_map(
            function (ComputedKeyEnum|string $v): string {
                return ($v instanceof ComputedKeyEnum) ? $v->value : $v;
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
