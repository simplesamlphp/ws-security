<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DateTimeImmutable;
use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\Assert\Assert as SAMLAssert;
use SimpleSAML\SAML2\XML\md\{ContactPerson, Extensions, KeyDescriptor, Organization};
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XMLSecurity\XML\ds\Signature;

use function preg_split;

/**
 * Class representing WS-federation SecurityTokenServiceType RoleDescriptor.
 *
 * @package simplesamlphp/ws-security
 */
final class SecurityTokenServiceType extends AbstractSecurityTokenServiceType
{
    /**
     * Convert XML into a SecurityTokenServiceType RoleDescriptor
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     * @throws \SimpleSAML\XML\Exception\TooManyElementsException
     *   if too many child-elements of a type are specified
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'RoleDescriptor', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $protocols = self::getAttribute($xml, 'protocolSupportEnumeration');
        $validUntil = self::getOptionalAttribute($xml, 'validUntil', null);
        SAMLAssert::nullOrValidDateTime($validUntil);

        $orgs = Organization::getChildrenOfClass($xml);
        Assert::maxCount(
            $orgs,
            1,
            'More than one Organization found in this descriptor',
            TooManyElementsException::class,
        );

        $extensions = Extensions::getChildrenOfClass($xml);
        Assert::maxCount(
            $extensions,
            1,
            'Only one md:Extensions element is allowed.',
            TooManyElementsException::class,
        );

        $logicalServiceNamesOffered = LogicalServiceNamesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $logicalServiceNamesOffered,
            1,
            'Only one fed:LogicalServiceNamesOffered is allowed.',
            TooManyElementsException::class,
        );

        $tokenTypesOffered = TokenTypesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $tokenTypesOffered,
            1,
            'Only one fed:TokenTypesOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimDialectsOffered = ClaimDialectsOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimDialectsOffered,
            1,
            'Only one fed:ClaimDialectsOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimTypesOffered = ClaimTypesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimTypesOffered,
            1,
            'Only one fed:ClaimTypesOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimTypesRequested = ClaimTypesRequested::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimTypesRequested,
            1,
            'Only one fed:ClaimTypesRequested is allowed.',
            TooManyElementsException::class,
        );

        $automaticPseudonyms = AutomaticPseudonyms::getChildrenOfClass($xml);
        Assert::maxCount(
            $automaticPseudonyms,
            1,
            'Only one fed:AutomaticPseudonyms is allowed.',
            TooManyElementsException::class,
        );

        $targetScopes = TargetScopes::getChildrenOfClass($xml);
        Assert::maxCount(
            $targetScopes,
            1,
            'Only one fed:TargetScopes is allowed.',
            TooManyElementsException::class,
        );

        $signature = Signature::getChildrenOfClass($xml);
        Assert::maxCount(
            $signature,
            1,
            'Only one ds:Signature element is allowed.',
            TooManyElementsException::class,
        );

        $securityTokenServiceType = new static(
            preg_split('/[\s]+/', trim($protocols)),
            self::getOptionalAttribute($xml, 'ID', null),
            $validUntil !== null ? new DateTimeImmutable($validUntil) : null,
            self::getOptionalAttribute($xml, 'cacheDuration', null),
            array_pop($extensions),
            self::getOptionalAttribute($xml, 'errorURL', null),
            KeyDescriptor::getChildrenOfClass($xml),
            array_pop($orgs),
            ContactPerson::getChildrenOfClass($xml),
            self::getAttributesNSFromXML($xml),
            array_pop($logicalServiceNamesOffered),
            array_pop($tokenTypesOffered),
            array_pop($claimDialectsOffered),
            array_pop($claimTypesOffered),
            array_pop($claimTypesRequested),
            array_pop($automaticPseudonyms),
            array_pop($targetScopes),
            self::getOptionalAttribute($xml, 'ServiceDisplayName', null),
            self::getOptionalAttribute($xml, 'ServiceDescription', null),
            SecurityTokenServiceEndpoint::getChildrenOfClass($xml),
            SingleSignOutSubscriptionEndpoint::getChildrenOfClass($xml),
            SingleSignOutNotificationEndpoint::getChildrenOfClass($xml),
            PassiveRequestorEndpoint::getChildrenOfClass($xml),
        );

        if (!empty($signature)) {
            $securityTokenServiceType->setSignature($signature[0]);
            $securityTokenServiceType->setXML($xml);
        }

        return $securityTokenServiceType;
    }
}
