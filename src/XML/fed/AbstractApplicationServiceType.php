<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DateTimeImmutable;
use DOMElement;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\Organization;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * A ApplicationServiceType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractApplicationServiceType extends AbstractWebServiceDescriptorType
{
    /** @var string */
    public const XSI_TYPE_PREFIX = 'fed';

    /** @var string */
    public const XSI_TYPE_NAME = 'ApplicationServiceType';

    /** @var string */
    public const XSI_TYPE_NAMESPACE = C::NS_FED;


    /**
     * ApplicationServiceType constructor.
     *
     * @param string[] $protocolSupportEnumeration A set of URI specifying the protocols supported.
     * @param string|null $ID The ID for this document. Defaults to null.
     * @param \DateTimeImmutable|null $validUntil Unix time of validity for this document. Defaults to null.
     * @param string|null $cacheDuration Maximum time this document can be cached. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\Extensions|null $extensions An array of extensions. Defaults to an empty array.
     * @param string|null $errorURL An URI where to redirect users for support. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\KeyDescriptor[] $keyDescriptor An array of KeyDescriptor elements.
     *   Defaults to an empty array.
     * @param \SimpleSAML\SAML2\XML\md\Organization|null $organization
     *   The organization running this entity. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\ContactPerson[] $contact An array of contacts for this entity.
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
     * @param \SimpleSAML\WSSecurity\XML\fed\ApplicationServiceEndpoint[] $applicationServiceEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\SingleSignOutNotificationEndpoint[] $singleSignOutNotificationEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\PassiveRequestorEndpoint[] $passiveRequestorEndpoint
     */
    final public function __construct(
        array $protocolSupportEnumeration,
        ?string $ID = null,
        ?DateTimeImmutable $validUntil = null,
        ?string $cacheDuration = null,
        ?Extensions $extensions = null,
        ?string $errorURL = null,
        array $keyDescriptor = [],
        ?Organization $organization = null,
        array $contact = [],
        array $namespacedAttributes = [],
        ?LogicalServiceNamesOffered $logicalServiceNamesOffered = null,
        ?TokenTypesOffered $tokenTypesOffered = null,
        ?ClaimDialectsOffered $claimDialectsOffered = null,
        ?ClaimTypesOffered $claimTypesOffered = null,
        ?ClaimTypesRequested $claimTypesRequested = null,
        ?AutomaticPseudonyms $automaticPseudonyms = null,
        ?TargetScopes $targetScopes = null,
        ?string $serviceDisplayName = null,
        ?string $serviceDescription = null,
        protected array $applicationServiceEndpoint = [],
        protected array $singleSignOutNotificationEndpoint = [],
        protected array $passiveRequestorEndpoint = [],
    ) {
        Assert::minCount($applicationServiceEndpoint, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $applicationServiceEndpoint,
            ApplicationServiceEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $singleSignOutNotificationEndpoint,
            SingleSignOutNotificationEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $passiveRequestorEndpoint,
            PassiveRequestorEndpoint::class,
            SchemaViolationException::class,
        );

        parent::__construct(
            static::XSI_TYPE_PREFIX . ':' . static::XSI_TYPE_NAME,
            $protocolSupportEnumeration,
            $ID,
            $validUntil,
            $cacheDuration,
            $extensions,
            $errorURL,
            $keyDescriptor,
            $organization,
            $contact,
            $namespacedAttributes,
            $logicalServiceNamesOffered,
            $tokenTypesOffered,
            $claimDialectsOffered,
            $claimTypesOffered,
            $claimTypesRequested,
            $automaticPseudonyms,
            $targetScopes,
            $serviceDisplayName,
            $serviceDescription,
        );
    }


    /**
     * Collect the value of the applicationServicEndpoint-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\ApplicationServiceEndpoint[]
     */
    public function getApplicationServiceEndpoint(): array
    {
        return $this->applicationServiceEndpoint;
    }


    /**
     * Collect the value of the singleSignOutNotificationtionEndpoint-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\SingleSignOutNotificationEndpoint[]
     */
    public function getSingleSignOutNotificationEndpoint(): array
    {
        return $this->singleSignOutNotificationEndpoint;
    }


    /**
     * Collect the value of the passiveRequestorEndpoint-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\PassiveRequestorEndpoint[]
     */
    public function getPassiveRequestorEndpoint(): array
    {
        return $this->passiveRequestorEndpoint;
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toUnsignedXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        foreach ($this->getApplicationServiceEndpoint() as $ase) {
            $ase->toXML($e);
        }

        foreach ($this->getSingleSignOutNotificationEndpoint() as $ssone) {
            $ssone->toXML($e);
        }

        foreach ($this->getPassiveRequestorEndpoint() as $pre) {
            $pre->toXML($e);
        }

        return $e;
    }
}
