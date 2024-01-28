<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use DOMElement;
use InvalidArgumentException;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class representing a wsp:OperatorContentType element.
 *
 * @package simplesamlphp/ws-security
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractOperatorContentType extends AbstractWspElement
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * Initialize a wsp:OperatorContentType
     *
     * @param (\SimpleSAML\WSSecurity\XML\wsp\All|
     *         \SimpleSAML\WSSecurity\XML\wsp\ExactlyOne|
     *         \SimpleSAML\WSSecurity\XML\wsp\Policy|
     *         \SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[] $operatorContent
     * @param \SimpleSAML\XML\Chunk[] $children
     */
    public function __construct(
        protected array $operatorContent = [],
        array $children = []
    ) {
        Assert::maxCount($operatorContent, C::UNBOUNDED_LIMIT);
        Assert::maxCount($children, C::UNBOUNDED_LIMIT);
        Assert::allIsInstanceOfAny(
            $operatorContent,
            [All::class, ExactlyOne::class, Policy::class, PolicyReference::class],
            InvalidDOMElementException::class,
        );
        Assert::allIsInstanceOfAny(
            $children,
            [Chunk::class],
            InvalidArgumentException::class,
        );

        $this->setElements($children);
    }


    /**
     * @return (\SimpleSAML\XML\Chunk|
     *         \SimpleSAML\WSSecurity\XML\wsp\All|
     *         \SimpleSAML\WSSecurity\XML\wsp\ExactlyOne|
     *         \SimpleSAML\WSSecurity\XML\wsp\Policy|
     *         \SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[] $operatorContent
     */
    public function getOperatorContent(): array
    {
        return $this->operatorContent;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getOperatorContent())
            && empty($this->getElements());
    }


    /*
     * Convert XML into an wsp:OperatorContentType element
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

        $operatorContent = $children = [];
        for ($n = $xml->firstChild; $n !== null; $n = $n->nextSibling) {
            if (!($n instanceof DOMElement)) {
                continue;
            } elseif ($n->namespaceURI === self::NS) {
                $operatorContent[] = match ($n->localName) {
                    'All' => All::fromXML($n),
                    'ExactlyOne' => ExactlyOne::fromXML($n),
                    'Policy' => Policy::fromXML($n),
                    'PolicyReference' => PolicyReference::fromXML($n),
                    default => null,
                };
                continue;
            }

            $children[] = new Chunk($n);
        }

        return new static($operatorContent, $children);
    }


    /**
     * Convert this wsp:OperatorContentType to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:OperatorContentType to.
     * @return \DOMElement This wsp:AbstractOperatorContentType element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getOperatorContent() as $n) {
            $n->toXML($e);
        }

        foreach ($this->getElements() as $c) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $c */
            $c->toXML($e);
        }

        return $e;
    }
}
