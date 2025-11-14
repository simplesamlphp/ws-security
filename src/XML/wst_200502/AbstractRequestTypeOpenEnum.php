<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\StringValue;

use function array_map;
use function explode;
use function implode;

/**
 * A RequestTypeOpenEnum element
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractRequestTypeOpenEnum extends AbstractWstElement
{
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = StringValue::class;


    /**
     * @param (\SimpleSAML\WSSecurity\XML\wst_200502\RequestTypeEnum|string)[] $values
     */
    public function __construct(array $values)
    {
        $values = array_map(
            function (RequestTypeEnum|string $v): string {
                return ($v instanceof RequestTypeEnum) ? $v->value : $v;
            },
            $values,
        );
        Assert::allValidURI($values, SchemaViolationException::class);

        $this->setContent(StringValue::fromString(implode(' ', $values)));
    }


    /**
     * Convert XML into a class instance
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(explode(' ', $xml->textContent));
    }
}
