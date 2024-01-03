<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DateTimeImmutable;
use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\XML\md\AbstractRoleDescriptorType;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\Organization;

/**
 * An WebServiceDescriptorType
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractWebServiceDescriptorType extends AbstractRoleDescriptorType
{
    /** @var string */
    public const NS = AbstractFedElement::NS;

    /** @var string */
    public const NS_PREFIX = AbstractFedElement::NS_PREFIX;


    /**
     * WebServiceDescriptorType constructor.
     *
     * @param string[] $protocolSupportEnumeration A set of URI specifying the protocols supported.
     * @param string|null $ID The ID for this document. Defaults to null.
     * @param \DateTimeImmutable|null $validUntil Unix time of validity for this document. Defaults to null.
     * @param string|null $cacheDuration Maximum time this document can be cached. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\Extensions|null $extensions An array of extensions. Defaults to an empty array.
     * @param string|null $errorURL An URI where to redirect users for support. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\KeyDescriptor[] $keyDescriptors An array of KeyDescriptor elements.
     *   Defaults to an empty array.
     * @param \SimpleSAML\SAML2\XML\md\Organization|null $organization
     *   The organization running this entity. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\ContactPerson[] $contacts An array of contacts for this entity.
     *   Defaults to an empty array.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\WSSecurity\XML\fed\LogicalServiceNamesOffered|null $logicalServiceNamesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\TokenTypesOffered|null $tokenTypesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimDialectsOffered|null $claimDialectsOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimTypesOffered|null $claimTypesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimTypesRequested|null $claimTypesRequested
     * @param \SimpleSAML\WSSecurity\XML\fed\AutomaticPseudonyms|null $automaticPseudonyms
     * @param \SimpleSAML\WSSecurity\XML\fed\TargetScopes|null $targetScopes
     * @param string|null $serviceDisplayName
     * @param string|null $serviceDescription
     * @param \SimpleSAML\WSSecurity\XML\fed\SecurityTokenServiceEndpoint[] $securityTokenServiceEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\SingleSignOutSubscriptionEndpoint[] $singleSignOutSubscriptionEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\SingleSignOutNotificationEndpoint[] $singleSignOutNotificationEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\PassiveRequestorEndpoint[] $passiveRequestorEndpoint
     */
    protected function __construct(
        array $protocolSupportEnumeration,
        ?string $ID = null,
        ?DateTimeImmutable $validUntil = null,
        ?string $cacheDuration = null,
        ?Extensions $extensions = null,
        ?string $errorURL = null,
        array $keyDescriptors = [],
        ?Organization $organization = null,
        array $contacts = [],
        array $namespacedAttributes = [],
        protected ?LogicalServiceNamesOffered $logicalServiceNamesOffered = null,
        protected ?TokenTypesOffered $tokenTypesOffered = null,
        protected ?ClaimDialectsOffered $claimDialectsOffered = null,
        protected ?ClaimTypesOffered $claimTypesOffered = null,
        protected ?ClaimTypesRequested $claimTypesRequested = null,
        protected ?AutomaticPseudonyms $automaticPseudonyms = null,
        protected ?TargetScopes $targetScopes = null,
        protected ?string $serviceDisplayName = null,
        protected ?string $serviceDescription = null,
    ) {
        parent::__construct(
            $protocolSupportEnumeration,
            $ID,
            $validUntil,
            $cacheDuration,
            $extensions,
            $errorURL,
            $keyDescriptors,
            $organization,
            $contacts,
            $namespacedAttributes,
        );
    }


    /**
     * Collect the value of the logicalSericeNamesOffered-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\LogicalServiceNamesOffered|null
     */
    public function getLogicalServiceNamesOffered(): ?LogicalServiceNamesOffered
    {
        return $this->logicalServiceNamesOffered;
    }


    /**
     * Collect the value of the tokenTypesOffered-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\TokenTypesOffered|null
     */
    public function getTokenTypesOffered(): ?TokenTypesOffered
    {
        return $this->tokenTypesOffered;
    }


    /**
     * Collect the value of the claimDialectsOffered-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ClaimDialectsOffered|null
     */
    public function getClaimDialectsOffered(): ?ClaimDialectsOffered
    {
        return $this->claimDialectsOffered;
    }


    /**
     * Collect the value of the claimTypesOffered-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ClaimTypesOffered|null
     */
    public function getClaimTypesOffered(): ?ClaimTypesOffered
    {
        return $this->claimTypesOffered;
    }


    /**
     * Collect the value of the claimTypesRequested-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ClaimTypesRequested|null
     */
    public function getClaimTypesRequested(): ?ClaimTypesRequested
    {
        return $this->claimTypesRequested;
    }


    /**
     * Collect the value of the automaticPseudonyms-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\AutomaticPseudonyms|null
     */
    public function getAutomaticPseudonyms(): ?AutomaticPseudonyms
    {
        return $this->automaticPseudonyms;
    }


    /**
     * Collect the value of the targetScopes-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\TargetScopes|null
     */
    public function getTargetScopes(): ?TargetScopes
    {
        return $this->targetScopes;
    }


    /**
     * Collect the value of the serviceDisplayName-property
     *
     * @return string|null
     */
    public function getServiceDisplayName(): ?string
    {
        return $this->serviceDisplayName;
    }


    /**
     * Collect the value of the serviceDescription-property
     *
     * @return string|null
     */
    public function getServiceDescription(): ?string
    {
        return $this->serviceDescription;
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toUnsignedXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toUnsignedXML($parent);

        $this->getLogicalServiceNamesOffered()?->toXML($e);
        $this->getTokenTypesOffered()?->toXML($e);
        $this->getClaimDialectsOffered()?->toXML($e);
        $this->getClaimTypesOffered()?->toXML($e);
        $this->getClaimTypesRequested()?->toXML($e);
        $this->getAutomaticPseudonyms()?->toXML($e);
        $this->getTargetScopes()?->toXML($e);

        $serviceDisplayName = $this->getServiceDisplayName();
        if ($serviceDisplayName !== null) {
            $e->setAttribute('ServiceDisplayName', $serviceDisplayName);
        }

        $serviceDescription = $this->getServiceDescription();
        if ($serviceDescription !== null) {
            $e->setAttribute('ServiceDescription', $serviceDescription);
        }

        return $e;
    }
}
