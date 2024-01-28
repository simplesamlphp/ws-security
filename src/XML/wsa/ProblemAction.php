<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

use function array_pop;

/**
 * A ProblemAction
 *
 * @package simplesamlphp/ws-security
 */
final class ProblemAction extends AbstractProblemActionType
{
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

        $action = Action::getChildrenOfClass($xml);
        Assert::maxCount(
            $action,
            1,
            'No more than one Action element allowed in <wsa:ProblemAction>.',
            TooManyElementsException::class,
        );

        $soapAction = SoapAction::getChildrenOfClass($xml);
        Assert::maxCount(
            $soapAction,
            1,
            'No more than one SoapAction element allowed in <wsa:ProblemAction>.',
            TooManyElementsException::class,
        );

        return new static(array_pop($action), array_pop($soapAction), self::getAttributesNSFromXML($xml));
    }
}
