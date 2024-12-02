<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

use function array_pop;

/**
 * Class defining the AuthenticatorType element
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAuthenticatorType extends AbstractWstElement
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractAuthenticatorType constructor
     *
     * @param \SimpleSAML\WSSecurity\XML\wst_200512\CombinedHash|null $combinedHash
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     */
    final public function __construct(
        protected ?CombinedHash $combinedHash = null,
        array $children = [],
    ) {
        $this->setElements($children);
    }


    /**
     * @return \SimpleSAML\WSSecurity\XML\wst_200512\CombinedHash|null
     */
    public function getCombinedHash(): ?CombinedHash
    {
        return $this->combinedHash;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getCombinedHash())
            && empty($this->getElements());
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

        $combinedHash = CombinedHash::getChildrenOfClass($xml);

        return new static(
            array_pop($combinedHash),
            self::getChildElementsFromXML($xml),
        );
    }


    /**
     * Add this AuthenticatorType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getCombinedHash()?->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
