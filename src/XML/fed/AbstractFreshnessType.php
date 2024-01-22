<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\StringElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function intval;
use function sprintf;
use function strval;

/**
 * Class defining the FreshnessType element
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractFreshnessType extends AbstractFedElement
{
    use StringElementTrait;
    use ExtendableAttributesTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractFreshnessType constructor
     *
     * @param int $content
     * @param bool|null $AllowCache
     * @param array $namespacedAttributes
     */
    final public function __construct(
        int $content,
        protected ?bool $AllowCache = null,
        array $namespacedAttributes = []
    ) {
        $this->setContent(strval($content));
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \Exception on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        Assert::natural(
            intval($content),
            sprintf(
                'The value \'%s\' of an %s:%s element must an unsigned integer.',
                $content,
                static::NS_PREFIX,
                static::getLocalName(),
            ),
            SchemaViolationException::class,
        );
    }


    /**
     * @return bool|null
     */
    public function getAllowCache(): ?bool
    {
        return $this->AllowCache;
    }


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
        Assert::integerish($xml->textContent, SchemaViolationException::class);

        return new static(
            intval($xml->textContent),
            self::getOptionalBooleanAttribute($xml, 'AllowCache', null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this IssuerNameType to an XML element.
     *
     * @param \DOMElement $parent The element we should append this issuer name to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        if ($this->getAllowCache() !== null) {
            $e->setAttribute('AllowCache', $this->getAllowCache() ? 'true' : 'false');
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
