<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * A RequestSecurityTokenCollectionType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractRequestSecurityTokenCollectionType extends AbstractWstElement
{
    /**
     * @param array<\SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityToken> $requestSecurityToken
     */
    final public function __construct(
        protected array $requestSecurityToken,
    ) {
        Assert::minCount($requestSecurityToken, 2, MissingElementException::class);
        Assert::allIsInstanceOf(
            $requestSecurityToken,
            RequestSecurityToken::class,
            SchemaViolationException::class,
        );
    }


    /**
     * Get the requestSecurityToken property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wst_200512\RequestSecurityToken[]
     */
    public function getRequestSecurityToken(): array
    {
        return $this->requestSecurityToken;
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
            RequestSecurityToken::getChildrenOfClass($xml),
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

        foreach ($this->getRequestSecurityToken() as $r) {
            $r->toXML($e);
        }

        return $e;
    }
}
