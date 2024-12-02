<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * A RequestSecurityTokenResponseCollectionType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRequestSecurityTokenResponseCollectionType extends AbstractWstElement
{
    use ExtendableAttributesTrait;

    /** @var string|\SimpleSAML\XML\XsNamespace */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * @param array<\SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityTokenResponse> $requestSecurityTokenResponse
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $requestSecurityTokenResponse,
        array $namespacedAttributes,
    ) {
        Assert::minCount($requestSecurityTokenResponse, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $requestSecurityTokenResponse,
            RequestSecurityTokenResponse::class,
            SchemaViolationException::class,
        );

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the requestSecurityTokenResponse property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityTokenResponse[]
     */
    public function getRequestSecurityTokenResponse(): array
    {
        return $this->requestSecurityTokenResponse;
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
            RequestSecurityTokenResponse::getChildrenOfClass($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getRequestSecurityTokenResponse() as $r) {
            $r->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
