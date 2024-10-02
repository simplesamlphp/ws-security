<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Base64ElementTrait;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_map;
use function explode;
use function implode;

/**
 * A BinarySecertType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractBinarySecretType extends AbstractWstElement
{
    use Base64ElementTrait;
    use ExtendableAttributesTrait;

    /** @var string|\SimpleSAML\XML\XsNamespace */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** @var string[]|null */
    protected ?array $Type;


    /**
     * @param string $content
     * @param (\SimpleSAML\WSSecurity\XML\wst_200502\BinarySecretTypeEnum|string)[]|null $Type
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        string $content,
        ?array $Type = null,
        array $namespacedAttributes = [],
    ) {
        if ($Type !== null) {
            $Type = array_map(
                function (BinarySecretTypeEnum|string $v): string {
                    return ($v instanceof BinarySecretTypeEnum) ? $v->value : $v;
                },
                $Type,
            );
            Assert::allValidURI($Type, SchemaViolationException::class);
            $this->Type = $Type;
        }

        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the Type property.
     *
     * @return string[]|null
     */
    public function getType(): ?array
    {
        return $this->Type;
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

        return new static(
            $xml->textContent,
            explode(' ', self::getAttribute($xml, 'Type')),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        if ($this->getType() !== null) {
            $e->setAttribute('Type', implode(' ', $this->getType()));
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
